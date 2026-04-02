<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CentroCostoController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\GerenciaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnidadNegocioController;
use App\Http\Controllers\UserController;
use App\Models\Area;
use App\Models\CentroCosto;
use App\Models\Direccion;
use App\Models\Division;
use App\Models\Empleado;
use App\Models\EmpleadoMovimientoAltaBaja;
use App\Models\Gerencia;
use App\Models\Puesto;
use App\Models\UnidadNegocio;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', function () {
    $stats = [
        'empleados_total' => Empleado::count(),
        'empleados_activos' => Empleado::where('activo', true)->count(),
        'empleados_baja' => Empleado::where('activo', false)->count(),
        'usuarios' => User::count(),
        'roles' => Role::count(),
        'permisos' => Permission::count(),
        'divisiones' => Division::count(),
        'unidades_negocio' => UnidadNegocio::count(),
        'centros_costos' => CentroCosto::count(),
        'direcciones' => Direccion::count(),
        'gerencias' => Gerencia::count(),
        'areas' => Area::count(),
        'puestos' => Puesto::count(),
        'puestos_activos' => Puesto::where('activo', true)->count(),
    ];

    $altasMes = EmpleadoMovimientoAltaBaja::where('tipo', EmpleadoMovimientoAltaBaja::TIPO_ALTA)
        ->whereMonth('fecha', now()->month)
        ->whereYear('fecha', now()->year)
        ->count();

    $bajasMes = EmpleadoMovimientoAltaBaja::where('tipo', EmpleadoMovimientoAltaBaja::TIPO_BAJA)
        ->whereMonth('fecha', now()->month)
        ->whereYear('fecha', now()->year)
        ->count();

    $ingresosRecientes = Empleado::with('puesto.area')
        ->orderByDesc('fecha_ingreso')
        ->limit(5)
        ->get();

    $movimientosRecientes = EmpleadoMovimientoAltaBaja::with('empleado.puesto')
        ->orderByDesc('fecha')
        ->orderByDesc('id')
        ->limit(5)
        ->get();

    return view('dashboard', compact('stats', 'altasMes', 'bajasMes', 'ingresosRecientes', 'movimientosRecientes'));
})->middleware(['auth', 'verified'])->name('dashboard')->can('ver-dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/estructura-organizacional', function () {
        $divisiones = Division::with([
            'unidadesNegocio.direcciones.gerencias.areas.puestos',
            'unidadesNegocio.direcciones.areas.puestos',
        ])->orderBy('nombre')->get();

        $centrosTodos = CentroCosto::with('areas.direccion')->where('activo', true)->get();
        $centrosPorUnidad = [];
        foreach ($centrosTodos as $cc) {
            foreach ($cc->areas as $area) {
                $uid = $area->direccion->unidad_negocio_id;
                $centrosPorUnidad[$uid] ??= [];
                $centrosPorUnidad[$uid][$cc->id] = $cc;
            }
        }
        foreach ($centrosPorUnidad as $uid => $map) {
            $centrosPorUnidad[$uid] = array_values($map);
        }
        $centrosCostoTotal = $centrosTodos->count();

        return view('estructura-organizacional', compact('divisiones', 'centrosPorUnidad', 'centrosCostoTotal'));
    })->name('estructura-organizacional');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulo de Usuarios
    Route::resource('users', UserController::class);

    // Módulo de Roles
    Route::resource('roles', RoleController::class);

    // Módulo de Permisos
    Route::resource('permissions', PermissionController::class);

    // Catálogos - Estructura Organizacional (relación: División → Unidad de Negocio → Dirección → Gerencia → Área → Puesto)
    Route::resource('divisiones', DivisionController::class)->parameters(['divisiones' => 'divisione']);
    Route::resource('unidades-negocio', UnidadNegocioController::class)->parameters(['unidades-negocio' => 'unidadNegocio']);
    Route::resource('centros-costos', CentroCostoController::class)->parameters(['centros-costos' => 'centroCosto']);
    Route::resource('direcciones', DireccionController::class)->parameters(['direcciones' => 'direccione']);
    Route::resource('gerencias', GerenciaController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('puestos', PuestoController::class);

    // Empleados
    Route::patch('empleados/{empleado}/toggle-baja', [EmpleadoController::class, 'toggleBaja'])->name('empleados.toggle-baja');
    Route::post('empleados/{empleado}/documentos', [EmpleadoController::class, 'storeDocument'])->name('empleados.documentos.store');
    Route::get('empleados/{empleado}/documentos/{documento}/descargar', [EmpleadoController::class, 'downloadDocument'])->name('empleados.documentos.download');
    Route::delete('empleados/{empleado}/documentos/{documento}', [EmpleadoController::class, 'destroyDocument'])->name('empleados.documentos.destroy');
    Route::resource('empleados', EmpleadoController::class);
});

require __DIR__.'/auth.php';
