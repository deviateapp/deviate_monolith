<?php

Route::middleware(['api'])->prefix('api')->group(function () {
    Route::post('/registration/register', \Deviate\Gateway\Registration\Controllers\RegisterOrganisation::class);
});
