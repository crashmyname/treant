<?php
namespace Support;

class DataTables
{
    public static function of(array $data)
    {
        return new static($data);
    }

    private $data;
    private $columns;

    public function __construct(array $data)
    {
        $this->data = $data;

        // Cek apakah data pertama adalah array atau objek
        if (!empty($data)) {
            // Jika data pertama adalah array, gunakan array_keys untuk mendapatkan kolom
            if (is_array($data[0])) {
                $this->columns = array_keys($data[0]);
            }
            // Jika data pertama adalah objek (stdClass), ubah menjadi array untuk mendapatkan kolom
            elseif (is_object($data[0])) {
                $this->columns = array_keys((array) $data[0]);
            }
        } else {
            $this->columns = [];
        }
    }

    public function make(bool $jsonEncode = false)
    {
        ob_start();
        // Mendapatkan parameter dari request
        $draw = isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 1;
        $start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
        $length = isset($_REQUEST['length']) ? intval($_REQUEST['length']) : 10;
        $searchValue = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $orderColumnIndex = isset($_REQUEST['order'][0]['column']) ? intval($_REQUEST['order'][0]['column']) : 0;
        $orderDir = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir'] : 'asc';

        // Kolom yang tersedia untuk pengurutan
        $orderColumn = $this->columns[$orderColumnIndex] ?? ($this->columns[0] ?? null);

        // Filter data berdasarkan pencarian
        $filteredData = array_filter($this->data, function ($item) use ($searchValue) {
            foreach ($item as $key => $value) {
                // Menangani baik array maupun objek
                $value = is_object($item) ? $item->$key : $value; // Mengakses nilai dengan cara objek atau array
                if (stripos((string) $value, $searchValue) !== false) {
                    return true;
                }
            }
            return false;
        });

        // Pengurutan data (menangani baik array maupun objek)
        usort($filteredData, function ($a, $b) use ($orderColumn, $orderDir) {
            $aValue = is_object($a) ? $a->$orderColumn : $a[$orderColumn];
            $bValue = is_object($b) ? $b->$orderColumn : $b[$orderColumn];

            if ($orderDir === 'asc') {
                return $aValue <=> $bValue;
            } else {
                return $bValue <=> $aValue;
            }
        });

        // Pagination
        $totalRecords = count($this->data);
        $totalFiltered = count($filteredData);
        $filteredData = array_slice($filteredData, $start, $length);

        // Menyiapkan data untuk respons DataTables
        $response = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $filteredData,
        ];

        if ($jsonEncode) {
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            return $response;
        }
    }
}
?>
