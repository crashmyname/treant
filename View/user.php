<?php 
echo 'Your ID : '.$_SESSION['user_id'].'<br>';
echo 'Username : '.$_SESSION['username'].'<br>';
echo 'Email : '.$_SESSION['email'];
?>
    <div class="container-fluid">
    <h1>Daftar Pengguna</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $field => $messages): ?>
                <?php foreach ($messages as $message): ?>
                    <li><?php echo htmlspecialchars($message); ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<a href="/mvc/adduser" class="btn btn-secondary">Tambah Pengguna</a>
<table id="datatable" class="table" style="width:100%">
    <thead>
        <tr>
            <td>User ID</td>
            <td>Nama</td>
            <td>UUID</td>
            <td>Email</td>
            <td>Password</td>
            <td>Action</td>
        </tr>
    </thead>
</table>
    </div>
    <script>
        $(document).ready(function() {
            var prefix = '<?= $_ENV['ROUTE_PREFIX']?>';
            var datatable = $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": prefix+"/user/getUsers",
                "columns": [
                    {"data": "user_id"},
                    {"data": "username"},
                    {"data": "uuid"},
                    {"data": "email"},
                    {"data": "password"},
                    {
                        "data": "user_id",
                        render: function(data,type,row){
                            var editLink = `${prefix}/formedit?id=${encodeURIComponent(row.edit_link)}`;
                            var deleteLink = `${prefix}/delete?id=${encodeURIComponent(row.delete_link)}`;
                            return `<a href="${editLink}" class="btn btn-warning">Edit</a> | <a href="${deleteLink}" class="btn btn-danger" onclick="return confirm('Apakah yakin ingin dihapus?')">Delete</a>`
                        },
                        "orderable": false
                    }
                ]
            });
            // function reload(){
            //     datatable.ajax.reload();
            // }
            // setInterval(reload, 5000);
        });
        // function refreshTable()
        // {
        //     var routePrefix = "<?php echo $_ENV['ROUTE_PREFIX']; ?>";
        //     fetch(routePrefix+'/user')
        //     .then(response => response.text())
        //     .then(data => {
        //         const parser = new DOMParser();
        //         const doc = parser.parseFromString(data,'text/html');
        //         const newTable = doc.querySelector('#datatable').innerHTML;
        //         document.querySelector('#datatable').innerHTML = newTable;
        //     })
        //     .catch(error=>console.error('error fetching data:', error));
        // }
        // setInterval(refreshTable, 5000);
    </script>

