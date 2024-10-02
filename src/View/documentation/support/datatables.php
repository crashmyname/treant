<section class="section">
    <div class="section-header">
        <h1>Datatables</h1>
    </div>

    <div class="section-body">
        <h4>Helper Datatable</h4>
        <b>Helper Datatable bisa melakukan proses serverside dengan sangat mudah</b><br>
        Berikut cara menggunakan helper datatable ini pertama import datatablenya:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\DataTables;');
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan Function:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('Request::isAjax()
Masukkan Model kalian
return DataTables::of(model kalian)->make(true);');
        echo '</code>';
        echo '</pre>';
        ?>
        Berikut cara lengkap menggunakan datatable:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\DataTables;
public function getUsers()
{
    if (Request::isAjax()) {
        $users = User::all();
        return DataTables::of($users)->make(true);
    }
}');
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
