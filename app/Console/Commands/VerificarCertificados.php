<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Certificado;

class VerificarCertificados extends Command
{
    protected $signature = 'certificados:verificar';
    protected $description = 'Actualizar estado de certificados';

    public function handle()
    {
        $certificados = Certificado::all();

        foreach ($certificados as $certificado) {
            $certificado->estado = $certificado->estado_calculado;
            $certificado->save();
        }

        $this->info('Certificados verificados correctamente.');
    }
}
