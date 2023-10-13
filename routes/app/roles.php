<?php

use Illuminate\Support\Facades\Route;
use LaravelLiberu\Roles\Http\Controllers\Create;
use LaravelLiberu\Roles\Http\Controllers\Destroy;
use LaravelLiberu\Roles\Http\Controllers\Edit;
use LaravelLiberu\Roles\Http\Controllers\ExportExcel;
use LaravelLiberu\Roles\Http\Controllers\InitTable;
use LaravelLiberu\Roles\Http\Controllers\Options;
use LaravelLiberu\Roles\Http\Controllers\Store;
use LaravelLiberu\Roles\Http\Controllers\TableData;
use LaravelLiberu\Roles\Http\Controllers\Update;

Route::get('create', Create::class)->name('create');
Route::post('', Store::class)->name('store');
Route::get('{role}/edit', Edit::class)->name('edit');
Route::patch('{role}', Update::class)->name('update');
Route::delete('{role}', Destroy::class)->name('destroy');

Route::get('initTable', InitTable::class)->name('initTable');
Route::get('tableData', TableData::class)->name('tableData');
Route::get('exportExcel', ExportExcel::class)->name('exportExcel');

Route::get('options', Options::class)->name('options');
