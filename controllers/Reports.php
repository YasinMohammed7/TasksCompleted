<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;

class Reports extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('pdf');
        $this->load->model('user');
        $this->load->model('StartUp_model');
        $this->load->model('Delivery_Model');
        $this->load->model('Sample');
        $this->load->model('Production_Report_Model');
    }

    public function samples_reports($type)
    {
        $user = $this->user->getRows(array('id' => $this->session->userdata('userId')));
        if (!$user) {
            redirect('users/login');
        }
        $company_id = $user['companyid'];
        $data['type'] = $type;

        switch ($type) {
            case '1':
                $title = $this->lang->line('production_organization_report');
                break;
            case '2':
                $title = $this->lang->line('production_tracking_report');
                break;
            case '3':
                $title = $this->lang->line('responsible_phases_report');
                break;
            case '4':
                $title = $this->lang->line('launched_samples_report');
                break;
            case '5':
                $title = $this->lang->line('Report_samples_responsibility');
                break;

            default:
                $title = 'Raport';
                break;
        }
        $options = $this->Production_Report_Model->get_samples_report($company_id, $type);

        $fineness = [];
        $composition = [];
        $metric_number = [];
        $clients = [];
        $sample_details = [];
        $expiry_date = [];
        $in_charge = [];
        $in_charge_client = [];
        $in_charge_confection = [];
        $name = [];
        $ref_clients = [];

        foreach ($options as $option) {
            if (isset($option['company_type']) && !in_array($option['company_type'], $clients)) {
                $clients[] = $option['company_type'];
            }
            if (isset($option['name']) && !in_array($option['name'], $name)) {
                $name[] = $option['name'];
            }
            if (isset($option['composition']) && !in_array($option['composition'], $composition)) {
                $composition[] = $option['composition'];
            }
            if (isset($option['metric_number']) && !in_array($option['metric_number'], $metric_number)) {
                $metric_number[] = $option['metric_number'];
            }
            if (isset($option['fineness']) && !in_array($option['fineness'], $fineness)) {
                $fineness[] = $option['fineness'];
            }
            if (isset($option['expiry_date']) && !in_array($option['expiry_date'], $expiry_date)) {
                $expiry_date[] = $option['expiry_date'];
            }
            if (isset($option['in_charge']) && !in_array($option['in_charge'], $in_charge)) {
                $in_charge[] = $option['in_charge'];
            }
            if (isset($option['in_charge_client']) && !in_array($option['in_charge_client'], $in_charge_client)) {
                $in_charge_client[] = $option['in_charge_client'];
            }
            if (isset($option['in_charge_confection']) && !in_array($option['in_charge_confection'], $in_charge_confection)) {
                $in_charge_confection[] = $option['in_charge_confection'];
            }
            if (isset($option['type']) && !in_array($option['type'], $sample_details)) {
                $sample_details[] = $option['type'];
            }
            if (isset($option['client_reference']) && !in_array($option['client_reference'], $ref_clients)) {
                $ref_clients[] = $option['client_reference'];
            }
        }
        $data['title'] = $title;

        $data['clients'] = $clients;
        $data['name'] = $name;
        $data['composition'] = $composition;
        $data['metric_number'] = $metric_number;
        $data['fineness'] = $fineness;
        $data['expiry_date'] = $expiry_date;
        $data['in_charge'] = $in_charge;
        $data['in_charge_client'] = $in_charge_client;
        $data['in_charge_confection'] = $in_charge_confection;
        $data['sample_details'] = $sample_details;
        $data['ref_clients'] = $ref_clients;
        // $data['generate_report'] = false;

        // if ($this->input->post('submit_report')) {
        //     $data['generate_report'] = true;
        // }
        // print_r($data['generate_report']);
        // die();

        // echo "<pre>";
        // print_r($options);
        // die();

        $this->load->view('samples_reports', $data);
    }

    public function generate_html()
    {
        $user = $this->user->getRows(array('id' => $this->session->userdata('userId')));
        $company_id = $user['companyid'];
        $type = $_GET['type'];
        $title = $_GET['title'];

        $fineness = null;
        $composition = null;
        $metric_number = null;
        $clients = null;
        $samplers_details = null;
        $from_date_execution = null;
        $to_date_execution = null;
        $in_charge = null;
        $in_charge_client = null;
        $in_charge_confection = null;
        $name = null;
        $total_option = null;
        $total_client = null;
        $ref_clients = null;


        $fineness = $_GET['fineness'] ?? null;
        $from_date = $_GET['from_date'] ?? date('d.m.Y');
        $to_date = $_GET['to_date'] ?? date('d.m.Y');
        $from_array = explode('.', $from_date);
        $to_array = explode('.', $to_date);

        $from_date_sql = $from_array[2] . '-' . $from_array[1] . '-' . $from_array[0] ?? '1970-01-01';
        $to_date_sql = $to_array[2] . '-' . $to_array[1] . '-' . $to_array[0] ?? date('Y-m-d');

        $samplers_details = $_GET['samplers_details'] ?? null;

        if ($type !== '4') {
            $clients = $_GET['clients'] ?? null;
        }

        if ($type === '1' || $type === '3' || $type === '5') {
            $in_charge = $_GET['in_charge'] ?? null;
            $in_charge_client = $_GET['in_charge_client'] ?? null;
            $in_charge_confection = $_GET['in_charge_confection'] ?? null;
            $from_date_execution = !empty($_GET['from_date_execution'])
                ? date('Y-m-d', strtotime($_GET['from_date_execution']))
                : null;

            $to_date_execution = !empty($_GET['to_date_execution'])
                ? date('Y-m-d', strtotime($_GET['to_date_execution']))
                : null;
        }

        if ($type === '4') {
            $name = $_GET['name'] ?? null;
            $composition = $_GET['composition'] ?? null;
            $metric_number = $_GET['metric_number'] ?? null;
            $ref_clients = $_GET['client_reference'] ?? null;
        }

        if ($type === '3') {
            if (isset($_GET['selection_after'])) {
                $total_option = $_GET['selection_after'];
            }
        }

        if ($type !== '3') {
            if (isset($_GET['total_client'])) {
                $total_client = $_GET['total_client'];
            }
        }

        // echo '<pre>';
        // print_r($_GET);
        // die();

        $options = $this->Production_Report_Model->get_samples_report(
            $company_id,
            $type,
            $fineness,
            $composition,
            $metric_number,
            $clients,
            $samplers_details,
            $from_date_execution,
            $to_date_execution,
            $in_charge,
            $in_charge_client,
            $in_charge_confection,
            $name,
            $from_date_sql,
            $to_date_sql,
            $total_option,
            $ref_clients
        );


        $rows = '';
        $rows_second_tbl = '';
        $total_nr_of_pieces = 0;
        $total_done_pieces = 0;
        $total_samples_done = 0;
        $total_startup_qty = 0;
        $total_trico_qty = 0;
        $colspan = 0;
        $colspan_second = 0;

        $totals_by_company = [];
        $current_company = '';
        $subtotal_nr_of_pieces = 0;
        $subtotal_done_pieces = 0;
        $key_total_option = '';
        $is_selected = false;
        $option_date = '';
        if ($type === '3') {
            $option_date = 'done_date';
        } elseif ($type === '5') {
            $option_date = 'startup_date';
        } else {
            $option_date = 'request_date';
        }
        foreach ($options as $option) {

            if ($total_option === 'total_per_in_charge_confection') {
                $is_selected = true;
                $key_total_option = 'in_charge_confection';
            } elseif ($total_option === 'total_per_in_charge') {
                $is_selected = true;
                $key_total_option = 'in_charge';
            } elseif (isset($total_client)) {
                $is_selected = true;
                $key_total_option = 'company_type';
            } else {
                $is_selected = false;
                $key_total_option = '';
            }

            if ($is_selected) {

                if (trim($option[$key_total_option]) === '') {
                    $option[$key_total_option] = 'Nespecificat'; // Assign a label for empty string companies
                }

                if ($current_company !== $option[$key_total_option] && $current_company !== '') {
                    // Add subtotal row for the previous company
                    if ($type !== '3') {
                        $rows .= '<tr style="font-weight: bold;">';
                        $rows .= '<td colspan="' . ($colspan) . '" style="text-align: right; border: none; background-color: #99ccff;">Total ' . $this->lang->line('no_of_pieces') . ' ' . $current_company . ': ' . $subtotal_nr_of_pieces . '</td>';
                        $rows .= '</tr>';
                    }
                    $rows .= '<tr style="font-weight: bold;">';
                    $rows .= '<td colspan="' . ($colspan) . '" style="text-align: right; border: none; background-color: #99ccff;">Total ' . $this->lang->line('done_pieces') . ' ' . $current_company . ': ' . $subtotal_done_pieces . '</td>';
                    $rows .= '</tr>';
                    $subtotal_nr_of_pieces = 0;
                    $subtotal_done_pieces = 0;
                }

                $current_company = $option[$key_total_option];
            }
            // print_r($option);
            // echo $this->db->last_query();
            // die();

            // echo '<pre>';
            // print_r($startup_qty . '\n');
            // print_r($trico_quantity . '\n');
            // var_dump($option['startup_date']);

            // echo $this->db->last_query();
            // die();
            $formatted_request_date = date('d.m.Y', strtotime($option[$option_date]));
            $rows .= '<tr>';
            $rows_second_tbl .= '<tr>';
            $rows .= '<td>' . $formatted_request_date . '</td>';

            if (isset($option['no_of_pieces'])) {
                $subtotal_nr_of_pieces += $option['no_of_pieces'];
            }
            if (isset($option['done_pieces'])) {
                $subtotal_done_pieces += $option['done_pieces'];
            }
            if ($type === '1') {
                $formatted_expiry_date = date('d.m.Y', strtotime($option['expiry_date']));
                $total_nr_of_pieces += $option['no_of_pieces'];
                $total_done_pieces += $option['done_pieces'];
                $rows .= '<td>' . $option['company_type'] . '</td>';
                $rows .= '<td>' . $option['client_reference'] . '</td>';
                $rows .= '<td>' . $option['name'] . '</td>';
                $rows .= '<td>' . $option['composition'] . '</td>';
                $rows .= '<td>' . $option['metric_number'] . '</td>';
                $rows .= '<td>' . $option['fineness'] . '</td>';
                $rows .= '<td>' . $option['type'] . '</td>';
                $rows .= '<td>' . $option['no_of_pieces'] . '</td>';
                $rows .= '<td>' . $option['done_pieces'] . '</td>';
                $rows .= '<td>' . $option['in_charge'] . '</td>';
                $rows .= '<td>' . $option['in_charge_confection'] . '</td>';
                $rows .= '<td>' . $option['in_charge_client'] . '</td>';
                $rows .= '<td>' . $formatted_expiry_date . '</td>';
                $colspan = 14;
            } elseif ($type === '2') {
                $total_nr_of_pieces += $option['no_of_pieces'];
                $total_done_pieces += $option['done_pieces'];
                $rows .= '<td>' . $option['company_type'] . '</td>';
                $rows .= '<td>' . $option['client_reference'] . '</td>';
                $rows .= '<td>' . $option['type'] . '</td>';
                $rows .= '<td>' . $option['fineness'] . '</td>';
                $rows .= '<td>' . $option['no_of_pieces'] . '</td>';
                $rows .= '<td>' . $option['done_pieces'] . '</td>';
                $colspan = 7;
            } elseif ($type === '3') {
                $formatted_expiry_date = date('d.m.Y', strtotime($option['expiry_date']));
                $total_done_pieces += $option['done_pieces'];
                $rows .= '<td>' . $option['in_charge'] . '</td>';
                $rows .= '<td>' . $option['in_charge_confection'] . '</td>';
                $rows .= '<td>' . $option['in_charge_client'] . '</td>';
                $rows .= '<td>' . $option['company_type'] . '</td>';
                $rows .= '<td>' . $option['client_reference'] . '</td>';
                $rows .= '<td>' . $option['fineness'] . '</td>';
                $rows .= '<td>' . $option['type'] . '</td>';
                $rows .= '<td>' . $option['done_pieces'] . '</td>';
                $rows .= '<td>' . $formatted_expiry_date . '</td>';
                $colspan = 10;
            } elseif ($type === '4') {
                $total_nr_of_pieces += $option['no_of_pieces'];
                $total_done_pieces += $option['done_pieces'];
                $total_samples_done += $option['sample_done'] ? 1 : 0;
                $rows .= '<td>' . $option['name'] . '</td>';
                $rows .= '<td>' . $option['composition'] . '</td>';
                $rows .= '<td>' . $option['metric_number'] . '</td>';
                $rows .= '<td>' . $option['client_reference'] . '</td>';
                $rows .= '<td>' . $option['company_type'] . '</td>';
                $rows .= '<td>' . $option['fineness'] . '</td>';
                $rows .= '<td>' . $option['type'] . '</td>';
                $rows .= '<td>' . $option['no_of_pieces'] . '</td>';
                $rows .= '<td>' . $option['done_pieces'] . '</td>';
                $rows .= '<td>' . ($option['sample_done'] ? 'Da' : 'Nu') . '</td>';
                $colspan = 11;
            } elseif ($type === '5') {

                $total_startup_qty += $startup_qty;
                $total_trico_qty += $trico_quantity;

                $total_nr_of_pieces += $option['no_of_pieces'];
                $total_done_pieces += $option['done_pieces'];
                $rows .= '<td>' . $option['in_charge'] . '</td>';
                $rows .= '<td>' . $option['in_charge_confection'] . '</td>';
                $rows .= '<td>' . $option['name'] . '</td>';
                $rows .= '<td>' . $option['company_type'] . '</td>';
                $rows .= '<td>' . $option['client_reference'] . '</td>';
                $rows .= '<td>' . $option['fineness'] . '</td>';
                $rows .= '<td>' . $startup_qty . '</td>';
                $rows .= '<td>' . $trico_quantity . '</td>';
                $rows .= '<td>' . $startup_qty - $trico_quantity . '</td>';
                $rows .= '<td>' . date('d.m.Y', strtotime($option['delivery_time'])) . '</td>';
                // $rows .= '<td>' . $option['type'] . '</td>';
                // $rows .= '<td>' . $option['no_of_pieces'] . '</td>';
                // $rows .= '<td>' . $option['done_pieces'] . '</td>';
                // $rows .= '<td>' . date('d.m.Y', strtotime($option['expiry_date'])) . '</td>';
                $colspan = 11;

                $rows_second_tbl .= '<td>' . date('d.m.Y', strtotime($option['request_date'])) . '</td>';
                $rows_second_tbl .= '<td>' . $option['in_charge'] . '</td>';
                $rows_second_tbl .= '<td>' . $option['in_charge_confection'] . '</td>';
                $rows_second_tbl .= '<td>' . $option['company_type'] . '</td>';
                $rows_second_tbl .= '<td>' . $option['client_reference'] . '</td>';
                $rows_second_tbl .= '<td>' . $option['fineness'] . '</td>';
                $rows_second_tbl .= '<td>' . $option['type'] . '</td>';
                $rows_second_tbl .= '<td>' . $option['no_of_pieces'] . '</td>';
                $rows_second_tbl .= '<td>' . $option['done_pieces'] . '</td>';
                $rows_second_tbl .= '<td>' . $option['no_of_pieces'] - $option['done_pieces'] . '</td>';
                $rows_second_tbl .= '<td>' . date('d.m.Y', strtotime($option['expiry_date'])) . '</td>';
                $colspan_second = 11;
            }
            $rows .= '</tr>';
            $rows_second_tbl .= '</tr>';
        }
        // die();

        if ($is_selected) {
            if ($type !== '3') {
                $rows .= '<tr style="font-weight: bold;">';
                $rows .= '<td colspan="' . $colspan . '" style="text-align: right; border: none; background-color: #99ccff;">';
                $rows .= 'Total ' . $this->lang->line('no_of_pieces') . ' ' . $current_company . ': ' . $subtotal_nr_of_pieces;
                $rows .= '</td>';
                $rows .= '</tr>';
            }
            $rows .= '<tr style="font-weight: bold;">';
            $rows .= '<td colspan="' . $colspan . '" style="text-align: right; border: none; background-color: #99ccff;">';
            $rows .= 'Total ' . $this->lang->line('done_pieces') . ' ' . $current_company . ': ' . $subtotal_done_pieces;
            $rows .= '</td>';
            $rows .= '</tr>';
        }

        if ($type !== '3' && $type !== '5') {
            $rows .= "<tr><td colspan='$colspan' style='text-align: right; border: none; font-weight: bold;'>Total {$this->lang->line('no_of_pieces')}:  $total_nr_of_pieces </td></tr>";
        }
        if ($type === '4') {
            $rows .= "<tr><td colspan='$colspan' style='text-align: right; border: none; font-weight: bold;'>Total {$this->lang->line('sample_done')}:  $total_samples_done </td></tr>";
        }
        if ($type !== '5')
            $rows .= "<tr><td colspan='$colspan' style='text-align: right; border: none; font-weight: bold;'>Total {$this->lang->line('done_pieces')}:  $total_done_pieces </td></tr>";
        if ($type === '5') {
            $for_knitting_qty = $total_startup_qty - $total_trico_qty;

            $rows .= "<tr><td colspan='$colspan' style='text-align: right; border: none; font-weight: bold;'>Total {$this->lang->line('launch_quantity')}:  $total_startup_qty </td></tr>";
            $rows .= "<tr><td colspan='$colspan' style='text-align: right; border: none; font-weight: bold;'>Total {$this->lang->line('knitting_qty')}:  $total_trico_qty </td></tr>";
            $rows .= "<tr><td colspan='$colspan' style='text-align: right; border: none; font-weight: bold;'>Total {$this->lang->line('for_knitting_qty')}:  $for_knitting_qty </td></tr>";
            $rows_second_tbl .= "<tr><td colspan='$colspan_second' style='text-align: right; border: none; font-weight: bold;'>Total {$this->lang->line('no_of_pieces')}:  $total_nr_of_pieces </td></tr>";
            $rows_second_tbl .= "<tr><td colspan='$colspan_second' style='text-align: right; border: none; font-weight: bold;'>Total {$this->lang->line('done_pieces')}:  $total_done_pieces </td></tr>";
        }
        // print_r($rows_second_tbl);
        // die();

        $html_content = $this->load->view('sample_report_pdf', [
            'rows' => $rows,
            'rows_second_tbl' => $rows_second_tbl,
            'type' => $type,
            'company' => $user['company'],
            'title' => $title,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'from_date_exec' => $from_date_execution,
            'to_date_exec' => $to_date_execution,
            'filters' => $_GET,
            'option_date' => $option_date
        ], true);

        $data = [
            'html_content' => $html_content,
            'title' => $title,
            'company_id' => $company_id,
            'type' => $type
        ];

        return $data;
    }

    public function samples_report_pdf()
    {

        $data = $this->generate_html();

        if ($data['type'] === '2') {
            $this->pdf->setPaper('A4', 'portrait');
        } else {
            $this->pdf->setPaper('A4', 'landscape');
        }

        //load pdf here
        $this->pdf->loadHtml($data['html_content'], 'UTF-8');
        $this->pdf->render();
        // $this->output
        //     ->set_content_type('application/pdf')
        //     ->set_output($this->pdf->output());
        $this->pdf->stream(strtolower(str_replace([" ", '/'], "_", $data['title'] . '_' . $data['company_id'] . '_' . date("d.m.Y_h:i:sa"))), array("Attachment" => 0));
    }

    public function samples_report_excel()
    {
        $data = $this->generate_html();
        $html_content = $data['html_content'];
        $reader = new Html();
        $spreadsheet = $reader->loadFromString($html_content);

        $writer = new Xlsx($spreadsheet);
        date_default_timezone_set('UTC');
        $currentDateTime = date('d-m-Y_H-i-s', strtotime('+ 3 hours'));

        if (!file_exists('application/assets/xls')) {
            mkdir('application/assets/xls', 0777, true);
        }

        $title = str_replace([" ", "/"], "_", $data['title']);

        $filename = $title . '_' . $currentDateTime . '.xlsx';
        if (!file_exists('application/assets/xls/' . $title . '/' . $data['company_id'])) {
            mkdir('application/assets/xls/' . $title . '/' . $data['company_id'], 0777, true);
        }
        $fullPath = 'application/assets/xls/' . $title . '/' . $data['company_id'] . '/' . $filename;
        $writer->save($fullPath);

        //die();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($fullPath);
    }
}
