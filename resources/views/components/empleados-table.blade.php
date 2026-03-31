<?php

use App\Models\Empleado;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Empleado::with('jefeInmediato', 'puesto.area');

        $term = trim($this->search);
        if ($term !== '') {
            $like = '%' . $term . '%';
            $query->where(function ($q) use ($like) {
                $q->whereRaw('LOWER(apellido_paterno) LIKE LOWER(?)', [$like])
                    ->orWhereRaw('LOWER(apellido_materno) LIKE LOWER(?)', [$like])
                    ->orWhereRaw('LOWER(nombre) LIKE LOWER(?)', [$like])
                    ->orWhereHas('puesto', fn ($p) => $p->whereRaw('LOWER(nombre) LIKE LOWER(?)', [$like]))
                    ->orWhereHas('puesto.area', fn ($a) => $a->whereRaw('LOWER(nombre) LIKE LOWER(?)', [$like]));
            });
        }

        $empleados = $query->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->orderBy('nombre')
            ->paginate(10);

        $total = Empleado::count();
        $activos = Empleado::where('activo', true)->count();
        $inactivos = Empleado::where('activo', false)->count();

        return view('livewire.empleados-table', [
            'empleados' => $empleados,
            'total' => $total,
            'activos' => $activos,
            'inactivos' => $inactivos,
        ]);
    }
};
?>
