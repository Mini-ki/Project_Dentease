<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\KonsultasiController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\FeedController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Pasien\PasienDashboardController;
use App\Http\Controllers\Pasien\JadwalController;
use App\Http\Controllers\Pasien\BiayaController;
use App\Http\Controllers\Pasien\JanjiController;
use App\Http\Controllers\Pasien\KonsultasiController as PasienKonsultasiController;
use App\Http\Controllers\Dokter\DokterDashboardController;
use App\Http\Controllers\Dokter\JadwalController as DokterJadwalController;
use App\Http\Controllers\Dokter\JanjiTemuController;
use App\Http\Controllers\Dokter\RekamMedisController;
use App\Http\Controllers\Dokter\ProfilController;
use App\Http\Controllers\Dokter\UlasanController;
use App\Http\Controllers\Pasien\PasienProfileController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::middleware(['auth'], ['role: pasien'])->group(function () {
    Route::get('/pasien/janji', [JanjiController::class, 'create'])->name('pasien.janji');
    Route::post('/pasien/janji', [JanjiController::class, 'store'])->name('pasien.janji.store');
    Route::get('/pasien/konsultasi', [PasienKonsultasiController::class, 'index'])->name('pasien.konsultasi');
    Route::post('/pasien/konsultasi/store-rating', [PasienKonsultasiController::class, 'storeRating'])->name('pasien.konsultasi.storeRating');
    Route::post('/pasien/konsultasi/delete-rating', [PasienKonsultasiController::class, 'deleteRating'])->name('pasien.konsultasi.deleteRating');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/pasien/biaya', [BiayaController::class, 'index'])->name('pasien.biaya');
    Route::get('/pasien/jadwal', [JadwalController::class, 'index'])->name('pasien.jadwal');
    Route::get('/pasien/homepage', [PasienDashboardController::class, 'index'])->name('pasien.homepage');
    Route::get('/profile', [PasienProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [PasienProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'], ['role:super_admin,admin,operator'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/admin', AdminController::class);
    Route::resource('/dokter', DokterController::class);
    Route::resource('feed', FeedController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('layanan', LayananController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/cetak', [LaporanController::class, 'printReport'])->name('laporan.cetak');
    Route::patch('layanan/{id}/toggle-status', [LayananController::class, 'toggleStatus'])->name('layanan.toggle-status');
    Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi');
});

Route::middleware(['auth'], ['role:dokter'])->group(function () {
    Route::get('/dokter/dashboard', [DokterDashboardController::class, 'index'])->name('dokter.dashboard');
    Route::get('/dokter/jadwal', [DokterJadwalController::class, 'index'])->name('dokter.jadwal');
    Route::post('/dokter/jadwal', [DokterJadwalController::class, 'store'])->name('dokter.jadwal.store');
    Route::put('/dokter/jadwal', [DokterJadwalController::class, 'update'])->name('dokter.jadwal.update');
    Route::delete('/dokter/jadwal', [DokterJadwalController::class, 'destroy'])->name('dokter.jadwal.destroy');
    Route::get('/dokter/janjitemu', [JanjiTemuController::class, 'index'])->name('dokter.janjitemu');
    Route::put('/dokter/janjitemu/selesaikan', [JanjiTemuController::class, 'selesaikan'])->name('dokter.janjitemu.selesaikan');
    Route::get('/dokter/profil', [ProfilController::class, 'index'])->name('dokter.profil');
    Route::put('/dokter/profil', [ProfilController::class, 'update'])->name('dokter.profil.update');
    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam_medis');
    Route::put('/rekam-medis/update', [RekamMedisController::class, 'update'])->name('rekam_medis.update');
    Route::delete('/rekam-medis/delete', [RekamMedisController::class, 'destroy'])->name('rekam_medis.destroy');
    Route::get('/rekam-medis/{id_pasien}/detail', [RekamMedisController::class, 'showRekamMedis'])->name('rekam_medis.detail');
    Route::post('/rekam-medis/{id_pasien}/store-update', [RekamMedisController::class, 'storeOrUpdateRekamMedis'])->name('rekam_medis.store_update_rm');
    Route::get('/rekam-medis/{id_pasien}/delete-rm/{id_rekam_medis}', [RekamMedisController::class, 'deleteRekamMedis'])->name('rekam_medis.delete_rm');
    Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan');

});

?>
