<form action="<?= 'module'?>" method="POST">
<?= crsfToken()?>
    <label>Module Name:</label>
    <input type="text" name="module_name" required>
    
    <div id="columns">
        <label>Column Name:</label>
        <input type="text" name="columns[0][name]" required>
        
        <label>Type:</label>
        <select name="columns[0][type]">
            <option value="string">String</option>
            <option value="integer">Integer</option>
            <option value="text">Text</option>
            <!-- Tambahkan tipe data lainnya jika diperlukan -->
        </select>
        
        <label>Primary Key:</label>
        <input type="checkbox" name="columns[0][primary]" value="1">
    </div>
    
    <button type="button" onclick="addColumn()">Add Column</button>
    <button type="submit">Generate CRUD</button>
</form>

<script>
let columnIndex = 1;
function addColumn() {
    const columnsDiv = document.getElementById('columns');
    const newColumn = `
        <div>
            <label>Column Name:</label>
            <input type="text" name="columns[${columnIndex}][name]" required>
            
            <label>Type:</label>
            <select name="columns[${columnIndex}][type]">
                <option value="string">String</option>
                <option value="integer">Integer</option>
                <option value="text">Text</option>
            </select>
            
            <label>Primary Key:</label>
            <input type="checkbox" name="columns[${columnIndex}][primary]" value="1">
        </div>
    `;
    columnsDiv.insertAdjacentHTML('beforeend', newColumn);
    columnIndex++;
}
</script>
