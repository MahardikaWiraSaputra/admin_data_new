<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Indikator extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_data_dasar_indikator');
        if (!$this->ion_auth->logged_in()) redirect('/login');

        if (!$this->ion_auth_acl->has_permission('kelola_data_dasar'))
        {
            redirect('/main/dashboard');
        }
    }

    public function index()
    {
        if (!$this->ion_auth->in_group(array(1,2)))
        {
            $id = $this->ion_auth->user()->row()->id;
            $data['filter_skpd'] = $this->m_data_dasar_indikator->filter_skpd($id);
        }
        else
        {
            $data['filter_skpd'] = $this->m_data_dasar_indikator->filter_skpd();
        }
        $data['filter_kategori'] = $this->m_data_dasar_indikator->filter_kategori();
        $this->load->view('data_dasar/indikator/index', $data);
    }

    public function filter_urusan($id = false)
    {
        $data['filter_urusan'] = $this->m_data_dasar_indikator->filter_urusan($id);
        $this->load->view('data_dasar/indikator/v_filter_urusan', $data);
    }

    public function daftar()
    {
        $page = '1';
        $offset = '0';
        $limit = 25;
        $like = array();
        $where = array();
        $where_skpd = '';
        $where_urusan = '';
        $where_kategori = '';
        $where_pelaporan = '';

        if (isset($_POST['search_field']) && $_POST['search_field'] != NULL)
        {
            $like = array('a.INDIKATOR' => $_POST['search_field']);
        }

        if (isset($_POST['skpd']) && $_POST['skpd'] != NULL && $_POST['skpd'] != 'all')
        {
            $where_skpd = '(a.SKPD_ID = "' . $_POST['skpd'] . '")';
        }

        if (isset($_POST['urusan']) && $_POST['urusan'] != NULL && $_POST['urusan'] != 'all')
        {
            $where_urusan = '(a.URUSAN_ID = "' . $_POST['urusan'] . '")';
        }

        if (isset($_POST['kategori']) && $_POST['kategori'] != NULL && $_POST['kategori'] != 'all')
        {
            $where_kategori = array('a.KATEGORI' => $_POST['kategori']);
        }
        if (isset($_POST['pelaporan']) && $_POST['pelaporan'] != NULL && $_POST['pelaporan'] != 'all')
        {
            $where_pelaporan = '(a.'.$_POST['pelaporan'].' = 1)';
        }
        if (isset($_POST['page']) && $_POST['page'] != NULL)
        {
            $page = $_POST['page'];
            $pageof = $_POST['page'] - 1;
            $offset = $pageof * $limit;
        }

        if (isset($_POST['limit']) && $_POST['limit'] != NULL)
        {
            $limit = $_POST['limit'];
        }

        $data['page'] = $page;
        $data['limit'] = $limit;
        $where = array_merge($where);

        $data['total_items'] = $this->m_data_dasar_indikator->get_list_total($where, $where_skpd, $where_urusan, $where_kategori, $where_pelaporan, $like);
        $data['list_items'] = $this->m_data_dasar_indikator->get_list_data($where, $where_skpd, $where_urusan, $where_kategori, $where_pelaporan, $like, $limit, $offset);
        $this->load->view('data_dasar/indikator/v_list', $data);
    }

    public function tambah()
    {
        $data['filter_kategori'] = $this->m_data_dasar_indikator->filter_kategori();
        $this->load->view('data_dasar/indikator/v_tambah', $data);
    }

    public function simpan()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_skpd', 'SKPD', 'trim|required|numeric');
        $this->form_validation->set_rules('f_urusan', 'Urusan', 'trim|required|numeric');
        $this->form_validation->set_rules('f_indikator', 'Indikator', 'trim|required');
        if ($this->form_validation->run())
        {
            $skpd_id = htmlspecialchars($this->input->post('f_skpd'));
            $urusan_id = htmlspecialchars($this->input->post('f_urusan'));
            $indikator = htmlspecialchars($this->input->post('f_indikator'));
            $satuan = htmlspecialchars($this->input->post('f_satuan'));
            $kategori = implode(", ", $this->input->post('f_kategori'));
            $capaian = $this->input->post('f_capaian[]');
            $is_capaian = $this->input->post('is_capaian');
            $is_target = $this->input->post('is_target');
            $target = $this->input->post('f_target[]');
            $tahun = $this->input->post('f_tahun[]');
            $rpjmd = htmlspecialchars($this->input->post('is_rpjmd'));
            $renstra = htmlspecialchars($this->input->post('is_renstra'));
            $sdgs = htmlspecialchars($this->input->post('is_sdgs'));
            $spm = htmlspecialchars($this->input->post('is_spm'));
            $tidak_terisi = htmlspecialchars($this->input->post('is_tidak_terisi'));
            $lkjip = htmlspecialchars($this->input->post('lkjip'));
            $lkpj = htmlspecialchars($this->input->post('lkpj'));
            $lppd = htmlspecialchars($this->input->post('lppd'));
            $created = date('y-m-d h:i:s');
            $created_by = $this->ion_auth->user()->row()->id;
            $query = $this->m_data_dasar_indikator->tambah_indikator($skpd_id, $urusan_id, $indikator, $satuan, $kategori, $tahun, $capaian,$target, $is_capaian,$is_target, $rpjmd, $renstra, $sdgs, $spm,$tidak_terisi, $lkjip, $lkpj, $lppd, $created, $created_by);

            if ($query)
            {
                $output['success'] = true;
                $output['message'] = 'DATA BERHASIL DISIMPAN';
            }
            else
            {
                $output['success'] = false;
                $output['message'] = 'DATA GAGAL DISIMPAN';
            }
        }
        else
        {
            $output['success'] = false;
            $output['message'] = 'DATA GAGAL DISIMPAN';
        }
        echo json_encode($output);
    }

    // detail edit
    public function detail($id)
    {
        if ($id)
        {
            $data['detail'] = $this->m_data_dasar_indikator->detail_indikator($id);
            $this->load->view('data_dasar/indikator/v_detail', $data);
        }
        else
        {
            echo 'id tidka boleh kosong';
        }
    }

    public function edit($id)
    {
        if ($id)
        {
            $data['detail'] = $this->m_data_dasar_indikator->detail_indikator($id);
            $data['filter_kategori'] = $this->m_data_dasar_indikator->filter_kategori();
            $this->load->view('data_dasar/indikator/v_edit', $data);
        }
        else
        {
            echo 'id tidka boleh kosong';
        }
    }

    public function update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('f_skpd', 'SKPD', 'trim|numeric');
        $this->form_validation->set_rules('f_urusan', 'Urusan', 'trim|numeric');
        $this->form_validation->set_rules('f_indikator', 'Indikator', 'trim');
        if ($this->form_validation->run())
        {
            $detail = $this->m_data_dasar_indikator->detail_indikator($this->input->post('f_id'));
            $id = htmlspecialchars($this->input->post('f_id'));
            $skpd_id = htmlspecialchars($this->input->post('f_skpd'));
            if ($this->input->post('f_urusan') != '0')
            {
                $urusan_id = htmlspecialchars($this->input->post('f_urusan'));
            }
            else
            {
                $urusan_id = $detail['URUSAN_ID'];
            }
            $indikator = htmlspecialchars($this->input->post('f_indikator'));
            $satuan = htmlspecialchars($this->input->post('f_satuan'));

            if($this->input->post('f_kategori')){
                $kategori = implode(", ", $this->input->post('f_kategori'));
            } else {
                $kategori = '-';
            }
            

            $is_capaian = $this->input->post('is_capaian');
            $capaian = $this->input->post('f_capaian[]');
            $tahun = $this->input->post('f_tahun[]');
            
            $is_target = $this->input->post('is_target');
            $target = $this->input->post('f_target[]');
            $tahun_target = $this->input->post('f_tahun_target[]');

            $rpjmd = htmlspecialchars($this->input->post('is_rpjmd'));
            $renstra = htmlspecialchars($this->input->post('is_renstra'));
            $sdgs = htmlspecialchars($this->input->post('is_sdgs'));
            $spm = htmlspecialchars($this->input->post('is_spm'));
            $tidak_terisi = htmlspecialchars($this->input->post('is_tidak_terisi'));
            $lkjip = htmlspecialchars($this->input->post('lkjip'));
            $lkpj = htmlspecialchars($this->input->post('lkpj'));
            $lppd = htmlspecialchars($this->input->post('lppd'));

            $modified = date('y-m-d h:i:s');
            $modified_by = $this->ion_auth->user()->row()->id;

            $query = $this->m_data_dasar_indikator->update_indikator($id, $skpd_id, $urusan_id, $indikator, $satuan, $kategori, $tahun, $capaian, $target ,$tahun_target, $is_capaian, $is_target, $rpjmd, $renstra, $sdgs, $spm, $tidak_terisi, $lkjip, $lkpj, $lppd, $modified, $modified_by);
            if ($query)
            {
                $output['success'] = true;
                $output['message'] = 'DATA BERHASIL DISIMPAN';
            }
            else
            {
                $output['success'] = false;
                $output['message'] = 'DATA GAGAL DISIMPAN';
            }
        }
        else
        {
            $output['success'] = false;
            $output['message'] = 'DATA GAGAL DISIMPAN';
        }
        echo json_encode($output);
    }

    public function update_flagging($id)
    {
        if ($id)
        {
            $data['detail'] = $this->m_data_dasar_indikator->detail_indikator($id);
            $data['filter_kategori'] = $this->m_data_dasar_indikator->filter_kategori();
            $this->load->view('data_dasar/indikator/v_edit_flagging', $data);
        }
        else
        {
            echo 'id tidka boleh kosong';
        }
    }

    public function update_status($id, $tipe, $value)
    {
        if ($id)
        {
            $data['ID'] = $id;
            if ($tipe == 'rpjmd')
            {
                $data['RPJMD'] = $value;
            }
            elseif ($tipe == 'sdgs')
            {
                $data['SDGS'] = $value;
            }
            elseif ($tipe == 'spm')
            {
                $data['SPM'] = $value;
            }
            elseif ($tipe == 'renstra')
            {
                $data['RENSTRA'] = $value;
            }
            elseif ($tipe == 'tidak_terisi')
            {
                $data['TIDAK_TERISI'] = $value;
            }
            elseif ($tipe == 'klhs')
            {
                $data['KLHS'] = $value;
            }
            elseif ($tipe == 'lkjip')
            {
                $data['LKJIP'] = $value;
            }
            elseif ($tipe == 'lkpj')
            {
                $data['LKPJ'] = $value;
            }
            elseif ($tipe == 'lppd')
            {
                $data['LPPD'] = $value;
            }
            $query = $this->m_data_dasar_indikator->update_kodefikasi($data);
            if ($query)
            {
                $output['success'] = true;
                $output['message'] = 'KODEFIKASI BERHASIL DIUPDATE';
            }
            else
            {
                $output['success'] = false;
                $output['message'] = 'KODEFIKASI GAGAL DIUPDATE';
            }
        }
        else
        {
            $output['success'] = false;
            $output['message'] = 'KODEFIKASI GAGAL DIUPDATE';
        }
        echo json_encode($output);
    }

    public function delete($id)
    {
        if ($id)
        {
            $query = $this->m_data_dasar_indikator->delete_indikator($id);
            if ($query)
            {
                $output['success'] = true;
                $output['message'] = 'DATA BERHASIL DIUPDATE';
            }
            else
            {
                $output['success'] = false;
                $output['message'] = 'DATA GAGAL DIHAPUS';
            }
        }
        else
        {
            $output['success'] = false;
            $output['message'] = 'DATA GAGAL DIHAPUS';
        }
        echo json_encode($output);
    }

    public function cetak_laporan(){
        // $skpd=$this->input->post('i');
        $where_skpd = '';
        $where_urusan = '';
        $where_kategori = '';
        $where_pelaporan = '';
        $skpd_name = '';

        if (isset($_GET['skpd']) && $_GET['skpd'] != NULL && $_GET['skpd'] != 'all')
        {
            $where_skpd = '(a.SKPD_ID = "' . $_GET['skpd'] . '")';
            $skpd_name = $_GET['skpd'];
        }

        if (isset($_GET['urusan']) && $_GET['urusan'] != NULL && $_GET['urusan'] != 'all')
        {
            $where_urusan = '(a.URUSAN_ID = "' . $_GET['urusan'] . '")';
        }

        if (isset($_GET['kategori']) && $_GET['kategori'] != NULL && $_GET['kategori'] != 'all')
        {
            $where_kategori = array('a.KATEGORI' => $_GET['kategori']);
        }
        if (isset($_GET['pelaporan']) && $_GET['pelaporan'] != NULL && $_GET['pelaporan'] != 'all')
        {
            $where_pelaporan = '(a.'.$_GET['pelaporan'].' = 1)';
        }
        
        $nama_skpd = $this->m_data_dasar_indikator->get_skpd($skpd_name);
        if($nama_skpd){
            $nama_skpd = $nama_skpd['NAMA_SKPD'];
        } else {
            $nama_skpd = 'Semua Data';
        }
        $list_data = $this->m_data_dasar_indikator->get_data($where_skpd, $where_urusan, $where_kategori, $where_pelaporan);

        if($list_data){

            $spreadsheet = new Spreadsheet;

            $spreadsheet->setActiveSheetIndex(0)
                          ->setCellValue('A1', 'KODE INDIKATOR')
                          ->setCellValue('B1', 'INDIKATOR')
                          ->setCellValue('C1', 'URUSAN')
                          ->setCellValue('D1', 'SKPD')
                          ->setCellValue('E1', 'SATUAN')
                          ->setCellValue('F1', 'KATEGORI')
                          ->setCellValue('G1', 'RPJMD')
                          ->setCellValue('H1', 'SPM')
                          ->setCellValue('I1', 'SDGS')
                          ->setCellValue('J1', 'RENSTRA')
                          ->setCellValue('K1', 'KLHS')
                          ->setCellValue('L1', 'LKJIP')
                          ->setCellValue('M1', 'LKPJ')
                          ->setCellValue('N1', 'LPPD')
                          ->setCellValue('O1', 'TIDAK_TERISI')
                          ->setCellValue('P1', '2010')
                          ->setCellValue('Q1', '2011')
                          ->setCellValue('R1', '2012')
                          ->setCellValue('S1', '2013')
                          ->setCellValue('T1', '2014')
                          ->setCellValue('U1', '2015')
                          ->setCellValue('V1', '2016')
                          ->setCellValue('W1', '2017')
                          ->setCellValue('X1', '2018')
                          ->setCellValue('Y1', '2019')
                          ->setCellValue('Z1', '2020');
            $styleArray = [
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                      'outline' => [
                          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                          'color' => ['rgb' => '000000'],
                      ],
                  ],
                  'fill' => [
                      'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                      'startColor' => [
                        'argb' => 'ff5722',
                      ],
                      'endColor' => [
                          'argb' => 'ff5722',
                      ],
                  ],
            ];

            $styleBorder = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ]       
            ];
            // $spreadsheet->getDefaultStyle()->applyFromArray($styleBorder);

            $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($styleArray);
            // $spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleBorder);
            $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(15);

            $spreadsheet->getActiveSheet()->getStyle('A:Z')->getAlignment()->setWrapText(true);


            $kolom = 2;
            $nomor = 1;
            foreach($list_data as $data) {
            $spreadsheet->getActiveSheet()->getStyle('A2:Z'.$kolom)->applyFromArray($styleBorder);

                $spreadsheet->setActiveSheetIndex(0)
                               ->setCellValue('A' . $kolom, $data['KODE_INDIKATOR'])
                               ->setCellValue('B' . $kolom, $data['INDIKATOR'])
                               ->setCellValue('C' . $kolom, $data['URUSAN'])
                               ->setCellValue('D' . $kolom, $data['NAMA_SKPD'])
                               ->setCellValue('E' . $kolom, $data['SATUAN'])
                               ->setCellValue('F' . $kolom, $data['KATEGORI'])
                               ->setCellValue('G' . $kolom, $data['RPJMD'])
                               ->setCellValue('H' . $kolom, $data['SPM'])
                               ->setCellValue('I' . $kolom, $data['SDGS'])
                               ->setCellValue('J' . $kolom, $data['RENSTRA'])
                               ->setCellValue('K' . $kolom, $data['KLHS'])
                               ->setCellValue('L' . $kolom, $data['LKJIP'])
                               ->setCellValue('M' . $kolom, $data['LKPJ'])
                               ->setCellValue('N' . $kolom, $data['LPPD'])
                               ->setCellValue('O' . $kolom, $data['TIDAK_TERISI'])
                               ->setCellValue('P' . $kolom, $data['2010'])
                               ->setCellValue('Q' . $kolom, $data['2011'])
                               ->setCellValue('R' . $kolom, $data['2012'])
                               ->setCellValue('S' . $kolom, $data['2013'])
                               ->setCellValue('T' . $kolom, $data['2014'])
                               ->setCellValue('U' . $kolom, $data['2015'])
                               ->setCellValue('V' . $kolom, $data['2016'])
                               ->setCellValue('W' . $kolom, $data['2017'])
                               ->setCellValue('X' . $kolom, $data['2018'])
                               ->setCellValue('Y' . $kolom, $data['2019'])
                               ->setCellValue('Z' . $kolom, $data['2020'])
                               ;
                   $kolom++;
                   $nomor++;
                }

              $writer = new Xlsx($spreadsheet);

              header('Content-Type: application/vnd.ms-excel');
              
              header('Content-Disposition: attachment;filename="'.$nama_skpd.'.xlsx"');
              header('Cache-Control: max-age=0');
              $writer->save('php://output');

        } else {
          echo 'Data belum tersedia';
        }
    }

}

