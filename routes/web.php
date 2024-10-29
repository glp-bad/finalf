<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\App\ParteneriController;
use App\Http\Controllers\App\PartenerInvoicesController;
use App\Http\Controllers\App\PartenerInvoicesCashingInController;
use App\Http\Controllers\App\AvocatController;
use App\Http\Controllers\App\CheltuieliController;
use App\Http\Controllers\App\AnafController;


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

$pathBase = "public/";

Route::get('/', function () { return view('welcome'); });

// Auth::routes();
Route::post($pathBase . 'app/login',               [LoginController::class,             'login']);
Route::post($pathBase . 'app/appInfo',             [LoginController::class,             'appInfo']);        // not used
Route::post($pathBase . 'app/logout',              [LoginController::class,             'logout'])->middleware('auth');
Route::post($pathBase . 'app/loginCheck',          [LoginController::class,             'loginCheck'])->middleware('auth');

Route::post($pathBase . 'app/gridListParteneri',            [ParteneriController::class, 'gridListParteneri'])->middleware('auth');
Route::post($pathBase . 'app/partenerGetData',              [ParteneriController::class, 'partenerGetData'])->middleware('auth');
Route::post($pathBase . 'app/nomTipPartener',               [ParteneriController::class, 'nomTipPartener'])->middleware('auth');
Route::post($pathBase . 'app/nomLocalitati',                [ParteneriController::class, 'nomLocalitati'])->middleware('auth');
Route::post($pathBase . 'app/editPartener',                 [ParteneriController::class, 'editPartener'])->middleware('auth');
Route::post($pathBase . 'app/partener/listaAdrese',         [ParteneriController::class, 'listaAdrese'])->middleware('auth');
Route::post($pathBase . 'app/partener/listBancCont',        [ParteneriController::class, 'listBancCont'])->middleware('auth');
Route::post($pathBase . 'app/partener/setBancCont',         [ParteneriController::class, 'setBancCont'])->middleware('auth');
Route::post($pathBase . 'app/partener/editAccountPartener', [ParteneriController::class, 'editAccountPartener'])->middleware('auth');


Route::post($pathBase . 'app/partener/setActivAdress',     [ParteneriController::class, 'setActivAdress'])->middleware('auth');
Route::post($pathBase . 'app/partener/editAdressPartener', [ParteneriController::class, 'editAdressPartener'])->middleware('auth');

// invoice
Route::post($pathBase . 'app/listPartener'                     , [PartenerInvoicesController::class,  'listPartener'])->middleware('auth');
Route::post($pathBase . 'app/nomInvoiceType'                   , [PartenerInvoicesController::class,  'nomInvoiceType'])->middleware('auth');
Route::post($pathBase . 'app/nomInvoiceTemplate'               , [PartenerInvoicesController::class,  'nomInvoiceTemplate'])->middleware('auth');
Route::post($pathBase . 'app/invocesListPartener'              , [PartenerInvoicesController::class,  'invocesListPartener'])->middleware('auth');
Route::post($pathBase . 'app/invoice/insertInvoiceAntet'       , [PartenerInvoicesController::class,  'insertInvoiceAntet'])->middleware('auth');
Route::post($pathBase . 'app/invoice/checkWorkingInvoice'      , [PartenerInvoicesController::class,  'checkWorkingInvoice'])->middleware('auth');
Route::post($pathBase . 'app/invoice/deleteInvoiceAntet'       , [PartenerInvoicesController::class,  'deleteInvoiceAntet'])->middleware('auth');
Route::post($pathBase . 'app/invoice/insertInvoiceArticol'     , [PartenerInvoicesController::class,  'insertInvoiceArticol'])->middleware('auth');
Route::post($pathBase . 'app/invoice/detailInvoiceList'        , [PartenerInvoicesController::class,  'detailInvoiceList'])->middleware('auth');
Route::post($pathBase . 'app/invoice/deleteItemDetailInvoice'  , [PartenerInvoicesController::class,  'deleteItemDetailInvoice'])->middleware('auth');
Route::post($pathBase . 'app/invoice/saveInvoice'              , [PartenerInvoicesController::class,  'saveInvoice'])->middleware('auth');
Route::post($pathBase . 'app/invoice/invoicesList'             , [PartenerInvoicesController::class,  'invoicesList'])->middleware('auth');
Route::post($pathBase . 'app/invoice/deleteInvoice'            , [PartenerInvoicesController::class,  'deleteInvoice'])->middleware('auth');
Route::post($pathBase . 'app/invoice/invoicePrint'             , [PartenerInvoicesController::class,  'invoicePrint'])->middleware('auth');
Route::post($pathBase . 'app/invoice/reportExcelInvoiceEmitted', [PartenerInvoicesController::class,  'reportExcelInvoiceEmitted'])->middleware('auth');
Route::post($pathBase . 'app/invoice/downloadeFactura'         , [PartenerInvoicesController::class,  'downloadeFactura'])->middleware('auth');



// incasari
Route::post($pathBase . 'app/cashing/listaUnpaidInvoices', [PartenerInvoicesCashingInController::class,  'listaUnpaidInvoices'])->middleware('auth');
Route::post($pathBase . 'app/cashing/nomDocumentTipe',     [PartenerInvoicesCashingInController::class,  'nomDocumentTipe'])->middleware('auth');
Route::post($pathBase . 'app/cashing/saveIncoming',        [PartenerInvoicesCashingInController::class,  'saveIncoming'])->middleware('auth');
Route::post($pathBase . 'app/cashing/incomingList',        [PartenerInvoicesCashingInController::class,  'incomingList'])->middleware('auth');
Route::post($pathBase . 'app/cashing/deleteIncomingDoc',   [PartenerInvoicesCashingInController::class,  'deleteIncomingDoc'])->middleware('auth');
Route::post($pathBase . 'app/cashing/reportIncasari',      [PartenerInvoicesCashingInController::class,  'reportIncasari'])->middleware('auth');
Route::post($pathBase . 'app/cashing/receiptPrint',        [PartenerInvoicesCashingInController::class,  'receiptPrint'])->middleware('auth');

// cheltuieli
Route::post($pathBase . 'app/cheltuieli/nomTipCheltuieli'           ,[CheltuieliController::class,  'nomTipCheltuieli'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/insertExpenseAntet'         ,[CheltuieliController::class,  'insertExpenseAntet'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/checkWorkingExpense'        ,[CheltuieliController::class,  'checkWorkingExpense'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/deleteAntetExpense'         ,[CheltuieliController::class,  'deleteAntetExpense'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/nomCategoriCheltuieli'      ,[CheltuieliController::class,  'nomCategoriCheltuieli'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/listProducts'               ,[CheltuieliController::class,  'listProducts'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/nomTipUm'                   ,[CheltuieliController::class,  'nomTipUm'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/insertExpenseArticol'       ,[CheltuieliController::class,  'insertExpenseArticol'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/detailExpenseList'          ,[CheltuieliController::class,  'detailExpenseList'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/deleteExpenseArticol'       ,[CheltuieliController::class,  'deleteExpenseArticol'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/saveExpense'                ,[CheltuieliController::class,  'saveExpense'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/expenseList'                ,[CheltuieliController::class,  'expenseList'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/deleteSaveExpense'          ,[CheltuieliController::class,  'deleteSaveExpense'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/reportExcelExpense'         ,[CheltuieliController::class,  'reportExcelExpense'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/allProductsList'            ,[CheltuieliController::class,  'allProductsList'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/insertNewProduct'           ,[CheltuieliController::class,  'insertNewProduct'])->middleware('auth');
Route::post($pathBase . 'app/cheltuieli/updateProductName'          ,[CheltuieliController::class,  'updateProductName'])->middleware('auth');

// ANAF Efactura
Route::post($pathBase . 'app/anaf/testOauth'            ,[AnafController::class,  'testOauth'])->middleware('auth');
Route::post($pathBase . 'app/anaf/listaMesajeFactura'   ,[AnafController::class,  'listaMesajeFactura'])->middleware('auth');
Route::post($pathBase . 'app/anaf/upload'   ,[AnafController::class,  'upload'])->middleware('auth');

// avocat
Route::post($pathBase . 'app/avocat/monthList', [AvocatController::class,  'monthList'])->middleware('auth');
Route::post($pathBase . 'app/avocat/checkMonth', [AvocatController::class,  'checkMonth'])->middleware('auth');
Route::post($pathBase . 'app/avocat/insertMonth', [AvocatController::class,  'insertMonth'])->middleware('auth');


















// Route::post('app/logout',[LoginController::class, 'logout']);
