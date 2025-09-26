// routes/web.php
Route::prefix('pedidos')->group(function () {
    Route::get('/', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/crear', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::put('/{pedido}/priorizar', [PedidoController::class, 'priorizar'])->name('pedidos.priorizar');
    Route::post('/filtrar', [PedidoController::class, 'filtrar'])->name('pedidos.filtrar');
});