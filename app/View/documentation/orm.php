<section class="section">
    <div class="section-header">
        <h1>ORM</h1>
    </div>

    <div class="section-body">
        <h4>ORM adalah Pemanggilan query builder yang mudah jadi user tidak perlu melakuka query pada umumnya</h4>
        <b>Metode penggunaan ORM</b><br>
        All Pemanggilan semua data atau sama seperti SELECT *:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::all();';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan Select dan Get:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::query()->select("id","nama")->get();';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan First:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::query()->select("id","nama")->first(); <-- untuk mendapatkan data paling pertama';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan where:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::where("kondisi","=","$kondisi");<br>';
        echo '$yourmodel = YourModel::whereDate();<rb>';
        echo '$yourmodel = YourModel::whereMonth();<rb>';
        echo '$yourmodel = YourModel::whereYear();';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan distinct:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::query()->distinct();<br>';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan Join:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::query()->select()->join("a","a.a","=","b.a")->get();<br>';
        echo '$yourmodel = YourModel::query()->select()->leftJoin("a","a.a","=","b.a")->get();<br>';
        echo '$yourmodel = YourModel::query()->select()->rightJoin("a","a.a","=","b.a")->get();<br>';
        echo '$yourmodel = YourModel::query()->select()->innerJoin("a","a.a","=","b.a")->get();<br>';
        echo '$yourmodel = YourModel::query()->select()->outerJoin("a","a.a","=","b.a")->get();<br>';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan groupBy:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::query()->select()->groupBy("a")->get();<br>';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan orderBy:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::query()->select()->orderBy("a","asc")->get();<br>';
        echo '$yourmodel = YourModel::query()->select()->orderBy("a","desc")->get();<br>';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan Limit:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::query()->select()->limit(10);<br>';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan Count:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::query()->select()->count();<br>';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan Find:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::find($id);<br>';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan Save:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::find($id);<br>';
        echo '$yourmodel->save();';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan Update:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::find($id);<br>';
        echo '$yourmodel->update();';
        echo '</code>';
        echo '</pre>';
        ?>
        Penggunaan Delete:
        <?php echo '<pre style="background-color: #2d2d2d; color: #f8f8f2; padding: 10px; border-radius: 5px; overflow: auto;">';
        echo '<code style="font-family: Consolas, \'Courier New\', monospace;">';
        echo '$yourmodel = YourModel::find($id);<br>';
        echo '$yourmodel->delete();';
        echo '</code>';
        echo '</pre>';
        ?>
    </div>
</section>
