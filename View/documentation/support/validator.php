<section class="section">
    <div class="section-header">
        <h1>Validator</h1>
    </div>

    <div class="section-body">
        <h4>Helper Validator</h4>
        <b>Helper Validator adalah function untuk membuat validasi request dari user atau form</b><br>
        Import Validator:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('use Support\Validator;');
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Penggunaan Validator:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$data = [
            "email" => $request->email,
            "password" => $request->password
        ];
        $rule = [
            "email" => "required",
            "password" => "required"
        ];
        $result = User::create([
            "email" => $data["email"],
            "password"=> $data["password"]
        ]);');
        echo '<br>Untuk melakukan validasi beserta rule nya';
        echo '</code>';
        echo '</pre>';
        ?>
        Contoh Error atau kebegal validasi:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('$error = $this->validator->validate($data, $rule);');
        echo '</code>';
        echo '</pre>';
        ?>
        Macam macam validasi yang ada:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo htmlentities('validate|Required;
validate|Min
validate|Max
validate|Numeric
validate|Email
validate|Confirmed
validate|Age
validate|Regex
validate|FileSize
validate|Date
validate|Alphanumeric
validate|Image
validate|FileType');
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
