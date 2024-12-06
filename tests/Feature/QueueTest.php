<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Redis; // Para interactuar con Redis
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue; // Para simular colas
use App\Jobs\MyJob; // Reemplaza con tu clase de trabajo

class QueueTest extends TestCase
{
    use RefreshDatabase; // Si usas base de datos para los Jobs

    /** @test */
    public function it_dispatches_a_job_to_the_queue()
    {
        // Simula la cola
        Queue::fake();

        // Despacha un trabajo
        dispatch(new MyJob());

        // Verifica que el trabajo se haya despachado
        Queue::assertPushed(MyJob::class);
    }

    /** @test */
    public function it_dispatches_and_processes_a_job_in_real_queue()
    {
        // Despacha el trabajo
        dispatch(new MyJob());

        // Verifica si Redis está utilizando la cola
        $queueLength = \Illuminate\Support\Facades\Redis::connection()->llen('queues:default');
        \Log::info('Longitud de la cola antes de procesar:', ['length' => $queueLength]);
        $this->assertGreaterThan(0, $queueLength, 'El trabajo no se añadió a la cola Redis.');

        // Procesa el trabajo
        $this->artisan('queue:work --once');

        // Verifica que la cola esté vacía
        $queueLength = \Illuminate\Support\Facades\Redis::connection()->llen('queues:default');
        \Log::info('Longitud de la cola después de procesar:', ['length' => $queueLength]);
        $this->assertEquals(0, $queueLength, 'La cola no está vacía después de procesar el trabajo.');
    }

}
