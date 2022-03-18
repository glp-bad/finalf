<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\App\ParteneriController;
use App\Http\Controllers\App\PartenerInvoicesController;
use App\Http\Controllers\App\PartenerInvoicesCashingInController;
use App\Http\Controllers\App\AvocatController;
use App\Http\Controllers\App\CheltuieliController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('welcome'); });

// Auth::routes();
Route::post('app/login',               [LoginController::class,             'login']);
Route::post('app/logout',              [LoginController::class,             'logout'])->middleware('auth');
Route::post('app/loginCheck',          [LoginController::class,             'loginCheck'])->middleware('auth');

Route::post('app/gridListParteneri',            [ParteneriController::class, 'gridListParteneri'])->middleware('auth');
Route::post('app/partenerGetData',              [ParteneriController::class, 'partenerGetData'])->middleware('auth');
Route::post('app/nomTipPartener',               [ParteneriController::class, 'nomTipPartener'])->middleware('auth');
Route::post('app/nomLocalitati',                [ParteneriController::class, 'nomLocalitati'])->middleware('auth');
Route::post('app/editPartener',                 [ParteneriController::class, 'editPartener'])->middleware('auth');
Route::post('app/partener/listaAdrese',         [ParteneriController::class, 'listaAdrese'])->middleware('auth');
Route::post('app/partener/listBancCont',        [ParteneriController::class, 'listBancCont'])->middleware('auth');
Route::post('app/partener/setBancCont',         [ParteneriController::class, 'setBancCont'])->middleware('auth');
Route::post('app/partener/editAccountPartener', [ParteneriController::class, 'editAccountPartener'])->middleware('auth');


Route::post('app/partener/setActivAdress',     [ParteneriController::class, 'setActivAdress'])->middleware('auth');
Route::post('app/partener/editAdressPartener', [ParteneriController::class, 'editAdressPartener'])->middleware('auth');

// invoice
Route::post('app/listPartener'                     , [PartenerInvoicesController::class,  'listPartener'])->middleware('auth');
Route::post('app/nomInvoiceType'                   , [PartenerInvoicesController::class,  'nomInvoiceType'])->middleware('auth');
Route::post('app/nomInvoiceTemplate'               , [PartenerInvoicesController::class,  'nomInvoiceTemplate'])->middleware('auth');
Route::post('app/invocesListPartener'              , [PartenerInvoicesController::class,  'invocesListPartener'])->middleware('auth');
Route::post('app/invoice/insertInvoiceAntet'       , [PartenerInvoicesController::class,  'insertInvoiceAntet'])->middleware('auth');
Route::post('app/invoice/checkWorkingInvoice'      , [PartenerInvoicesController::class,  'checkWorkingInvoice'])->middleware('auth');
Route::post('app/invoice/deleteInvoiceAntet'       , [PartenerInvoicesController::class,  'deleteInvoiceAntet'])->middleware('auth');
Route::post('app/invoice/insertInvoiceArticol'     , [PartenerInvoicesController::class,  'insertInvoiceArticol'])->middleware('auth');
Route::post('app/invoice/detailInvoiceList'        , [PartenerInvoicesController::class,  'detailInvoiceList'])->middleware('auth');
Route::post('app/invoice/deleteItemDetailInvoice'  , [PartenerInvoicesController::class,  'deleteItemDetailInvoice'])->middleware('auth');
Route::post('app/invoice/saveInvoice'              , [PartenerInvoicesController::class,  'saveInvoice'])->middleware('auth');
Route::post('app/invoice/invoicesList'             , [PartenerInvoicesController::class,  'invoicesList'])->middleware('auth');
Route::post('app/invoice/deleteInvoice'            , [PartenerInvoicesController::class,  'deleteInvoice'])->middleware('auth');
Route::post('app/invoice/invoicePrint'             , [PartenerInvoicesController::class,  'invoicePrint'])->middleware('auth');

// incasari
Route::post('app/cashing/listaUnpaidInvoices', [PartenerInvoicesCashingInController::class,  'listaUnpaidInvoices'])->middleware('auth');
Route::post('app/cashing/nomDocumentTipe',     [PartenerInvoicesCashingInController::class,  'nomDocumentTipe'])->middleware('auth');
Route::post('app/cashing/saveIncoming',        [PartenerInvoicesCashingInController::class,  'saveIncoming'])->middleware('auth');
Route::post('app/cashing/incomingList',        [PartenerInvoicesCashingInController::class,  'incomingList'])->middleware('auth');
Route::post('app/cashing/deleteIncomingDoc',   [PartenerInvoicesCashingInController::class,  'deleteIncomingDoc'])->middleware('auth');

// cheltuieli
Route::post('app/cheltuieli/nomTipCheltuieli'           ,[CheltuieliController::class,  'nomTipCheltuieli'])->middleware('auth');
Route::post('app/cheltuieli/insertExpenseAntet'         ,[CheltuieliController::class,  'insertExpenseAntet'])->middleware('auth');
Route::post('app/cheltuieli/checkWorkingExpense'        ,[CheltuieliController::class,  'checkWorkingExpense'])->middleware('auth');
Route::post('app/cheltuieli/deleteAntetExpense'         ,[CheltuieliController::class,  'deleteAntetExpense'])->middleware('auth');
Route::post('app/cheltuieli/nomCategoriCheltuieli'      ,[CheltuieliController::class,  'nomCategoriCheltuieli'])->middleware('auth');
Route::post('app/cheltuieli/listProducts'               ,[CheltuieliController::class,  'listProducts'])->middleware('auth');
Route::post('app/cheltuieli/nomTipUm'                   ,[CheltuieliController::class,  'nomTipUm'])->middleware('auth');
Route::post('app/cheltuieli/insertExpenseArticol'       ,[CheltuieliController::class,  'insertExpenseArticol'])->middleware('auth');
Route::post('app/cheltuieli/detailExpenseList'          ,[CheltuieliController::class,  'detailExpenseList'])->middleware('auth');
Route::post('app/cheltuieli/deleteExpenseArticol'       ,[CheltuieliController::class,  'deleteExpenseArticol'])->middleware('auth');
Route::post('app/cheltuieli/saveExpense'                ,[CheltuieliController::class,  'saveExpense'])->middleware('auth');
Route::post('app/cheltuieli/expenseList'                ,[CheltuieliController::class,  'expenseList'])->middleware('auth');
Route::post('app/cheltuieli/deleteSaveExpense'          ,[CheltuieliController::class,  'deleteSaveExpense'])->middleware('auth');





// avocat
Route::post('app/avocat/monthList', [AvocatController::class,  'monthList'])->middleware('auth');
Route::post('app/avocat/checkMonth', [AvocatController::class,  'checkMonth'])->middleware('auth');
Route::post('app/avocat/insertMonth', [AvocatController::class,  'insertMonth'])->middleware('auth');


















// Route::post('app/logout',[LoginController::class, 'logout']);
