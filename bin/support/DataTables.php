<?php
namespace Support;

class DataTables
{
    private $data;
    private $columns;
    private $additionalData = []; // Tambahan untuk menyimpan data tambahan

    public static function of(array $data)
    {
        return new static($data);
    }

    public function __construct(array $data)
    {
        $this->data = $data;

        // Cek apakah data pertama adalah array atau objek
        if (!empty($data)) {
            if (is_array($data[0])) {
                $this->columns = array_keys($data[0]);
            } elseif (is_object($data[0])) {
                $this->columns = array_keys((array)$data[0]);
            }
        } else {
            $this->columns = [];
        }
    }

    // Tambahkan fungsi with untuk menambahkan data tambahan
    public function with(array $data)
    {
        $this->additionalData = array_merge($this->additionalData, $data);
        return $this;
    }

    public function make(bool $jsonEncode = false)
    {
        ob_start();

        $draw = isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 1;
        $start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
        $length = isset($_REQUEST['length']) ? intval($_REQUEST['length']) : 10;
        $searchValue = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $orderColumnIndex = isset($_REQUEST['order'][0]['column']) ? intval($_REQUEST['order'][0]['column']) : 0;
        $orderDir = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir'] : 'asc';

        $orderColumn = $this->columns[$orderColumnIndex] ?? ($this->columns[0] ?? null);

        $filteredData = array_filter($this->data, function ($item) use ($searchValue) {
            foreach ($item as $key => $value) {
                $value = is_object($item) ? $item->$key : $value;
                if (stripos((string)$value, $searchValue) !== false) {
                    return true;
                }
            }
            return false;
        });

        usort($filteredData, function ($a, $b) use ($orderColumn, $orderDir) {
            $aValue = is_object($a) ? $a->$orderColumn : $a[$orderColumn];
            $bValue = is_object($b) ? $b->$orderColumn : $b[$orderColumn];

            return $orderDir === 'asc' ? $aValue <=> $bValue : $bValue <=> $aValue;
        });

        $totalRecords = count($this->data);
        $totalFiltered = count($filteredData);
        $filteredData = array_slice($filteredData, $start, $length);

        // Tambahkan data tambahan ke dalam respons
        $response = array_merge([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $filteredData,
        ], $this->additionalData);

        if ($jsonEncode) {
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            return $response;
        }
    }
}
