<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            'home_model',
        ]);
        $this->db->query('SET SESSION sql_mode = ""');

        if (!$this->session->userdata('isLogIn')) {
            redirect('login');
        }
    }

    public function changeformat($num)
    {

        if ($num > 1000) {
            $x               = round($num);
            $x_number_format = number_format($x);
            $x_array         = explode(',', $x_number_format);
            $x_parts         = ['k', 'm', 'b', 't'];
            $x_count_parts   = count($x_array) - 1;
            $x_display       = $x;
            $x_display       = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];
            return $x_display;
        }

        return $num;
    }

    public function index()
    {
        if ($this->permission->method('dashboard', 'read')->access() == false) {

            if (isset($_GET['status'])) {
                redirect("dashboard/home/profile?status=done");
            } else {
                redirect("dashboard/home/profile");
            }
        }

        $data['title']  = display('home');
        $data['title2'] = "dashboard";
        #page path
        $data['module']     = "dashboard";
        $data['page']       = "home/home";
        $settinginfo        = $this->db->select('currency')->from('setting')->get()->row();
        $currencyinfo       = $this->db->select('currencyname,curr_icon')->from('currency')->where('currencyid', $settinginfo->currency)->get()->row();
        $ordernum           = $this->home_model->countorder();
        $data["totalorder"] = $this->changeformat($ordernum);
        $todayorder         = $this->home_model->todayorder();
        $data["todayorder"] = $this->changeformat($todayorder);
        $todayorderprice    = $this->home_model->todayamount();

        if ($todayorderprice->amount < 1000) {

            if ($todayorderprice->amount > 0) {
                $data["todayamount"] = $todayorderprice->amount . $currencyinfo->curr_icon;
            } else {
                $data["todayamount"] = "0";
            }
        } else {
            $data["todayamount"] = $this->changeformat($todayorderprice->amount);
        }

        $customer                  = $this->home_model->totalcustomer();
        $data["totalcustomer"]     = $this->changeformat($customer);
        $completeorder             = $this->home_model->countcompleteorder();
        $data["completeord"]       = $this->changeformat($completeorder);
        $totalreservation          = $this->home_model->totalreservation();
        $data["totalreservation"]  = $this->changeformat($totalreservation);
        $data["latestoreder"]      = $this->home_model->latestoreder();
        $data["onlineorder"]       = $this->home_model->latestonline();
        $data["latestreservation"] = $this->home_model->latestreservation();
        $data["latestpending"]     = $this->home_model->latestpending();
        $months                    = '';
        $salesamount               = '';
        $salesamountonline         = '';
        $totalorderonline          = '';
        $salesamountoffline        = '';
        $totalorderoffline         = '';
        $totalorder                = '';
        $year                      = date('Y');
        $numbery                   = date('y');
        $prevyear                  = $numbery - 1;
        $prevyearformat            = $year - 1;
        $syear                     = '';
        $syearformat               = '';

        for ($k = 1; $k < 13; $k++) {
            $month = date('m', strtotime("+$k month"));
            $gety  = date('y', strtotime("+$k month"));

            if ($gety == $numbery) {
                $syear       = $prevyear;
                $syearformat = $prevyearformat;
            } else {
                $syear       = $numbery;
                $syearformat = $year;
            }

            $monthly        = $this->home_model->monthlysaleamount($syearformat, $month);
            $odernum        = $this->home_model->monthlysaleorder($syearformat, $month);
            $monthlyonline  = $this->home_model->onlinesaleamount($syearformat, $month);
            $odernumonline  = $this->home_model->onlinesaleorder($syearformat, $month);
            $monthlyoffline = $this->home_model->offlinesaleamount($syearformat, $month);
            $odernumoffline = $this->home_model->offlinesaleorder($syearformat, $month);

            $salesamount .= $monthly . ', ';
            $totalorder .= $odernum . ', ';

            $salesamountonline .= $monthlyonline . ', ';
            $totalorderonline .= $odernumonline . ', ';
            $salesamountoffline .= $monthlyoffline . ', ';
            $totalorderoffline .= $odernumoffline . ', ';
            $months .= date('F-' . $syear, strtotime("+$k month")) . ',';
        }

        $data["monthlysaleamount"] = trim($salesamount, ',');
        $data["monthlysaleorder"]  = trim($totalorder, ',');
        $data["onlinesaleamount"]  = trim($salesamountonline, ',');
        $data["onlinesaleorder"]   = trim($totalorderonline, ',');
        $data["offlinesaleamount"] = trim($salesamountoffline, ',');
        $data["offlinesaleorder"]  = trim($totalorderoffline, ',');
        $sql                       = "SELECT 
        order_menu.`row_id`, 
        order_menu.`menu_id`,
        COUNT(order_menu.`menu_id`) AS totalmenu,
        SUM(order_menu.`menuqty`) AS qty,
        MAX(order_menu.`menuqty`) AS max_menuqty,
        order_menu.varientid,
        item_foods.ProductName,
        variant.variantName
    FROM 
        `order_menu`
    LEFT JOIN 
        item_foods 
        ON item_foods.ProductsID = order_menu.menu_id
    LEFT JOIN 
        variant 
        ON variant.variantid = order_menu.varientid
    GROUP BY 
        order_menu.`menu_id`, 
        order_menu.varientid
    ORDER BY 
        qty DESC
    LIMIT 15";
        $query                     = $this->db->query($sql);
        $topsell                   = $query->result();
        $data["topseller"]         = $topsell;

        $data["monthname"] = trim($months, ',');
        echo Modules::run('template/layout', $data);
    }

    public function onlineOfflineSalesReport($yearMonth = '')
    {
        $months             = '';
        $salesamountonline  = '';
        $totalorderonline   = '';
        $salesamountoffline = '';
        $totalorderoffline  = '';
        $numbery            = date('y');

        if ($yearMonth != 'dateEmpty') {
            $numbery = $yearMonth;
        }

        for ($k = 1; $k < 13; $k++) {

            $month = date('m', strtotime("+$k month"));

            $monthlyonline  = $this->home_model->onlinesaleamount($numbery, $month);
            $odernumonline  = $this->home_model->onlinesaleorder($numbery, $month);
            $monthlyoffline = $this->home_model->offlinesaleamount($numbery, $month);
            $odernumoffline = $this->home_model->offlinesaleorder($numbery, $month);

            $salesamountonline .= $monthlyonline . ', ';
            $totalorderonline .= $odernumonline . ', ';
            $salesamountoffline .= $monthlyoffline . ', ';
            $totalorderoffline .= $odernumoffline . ', ';
            $months .= date('F-' . $numbery, strtotime("+$k month")) . ',';
        }

        $data["onlinesaleamount"]  = trim($salesamountonline, ',');
        $data["onlinesaleorder"]   = trim($totalorderonline, ',');
        $data["offlinesaleamount"] = trim($salesamountoffline, ',');
        $data["offlinesaleorder"]  = trim($totalorderoffline, ',');
        $data["monthname"]         = trim($months, ',');

        echo json_encode($data);
    }

    public function salesReport($yearMonth = '')
    {
        $currentYear  = date('Y');
        $currentMonth = date('m');

        if ($yearMonth != 'dateEmpty') {
            list($year, $month) = explode("-", $yearMonth);
            $currentYear        = $year;
            $currentMonth       = $month;
        }

        $walkingCustomerSell    = $this->home_model->customerSalesReport($currentYear, $currentMonth, 1);
        $onlineCustomerSell     = $this->home_model->customerSalesReport($currentYear, $currentMonth, 2);
        $thirdPartyCustomerSell = $this->home_model->customerSalesReport($currentYear, $currentMonth, 3);
        $takeWayCustomerSell    = $this->home_model->customerSalesReport($currentYear, $currentMonth, 4);
        $qrCustomerSell         = $this->home_model->customerSalesReport($currentYear, $currentMonth, 99);

        if ($walkingCustomerSell || $onlineCustomerSell || $thirdPartyCustomerSell || $takeWayCustomerSell || $qrCustomerSell) {

            $dataValue = [$walkingCustomerSell ?? 0, $onlineCustomerSell ?? 0, $thirdPartyCustomerSell ?? 0, $takeWayCustomerSell ?? 0, $qrCustomerSell ?? 0];
        } else {
            $dataValue = [0, 0, 0, 0, 0, 0];
        }

        $dataLavels = ['Walk-in Sale', 'Online Sale', 'Third Party Sale', 'Take Way Sale', 'QR Customer Sale'];

        $output = ['dataValue' => $dataValue, 'lavels' => $dataLavels];

        echo json_encode($output);
    }

    public function chartjs()
    {
        $allbasicinfo       = "";
        $months             = '';
        $salesamount        = '';
        $salesamountonline  = '';
        $totalorderonline   = '';
        $salesamountoffline = '';
        $totalorderoffline  = '';
        $totalorder         = '';
        $year               = date('Y');
        $numbery            = date('y');
        $prevyear           = $numbery - 1;
        $prevyearformat     = $year - 1;
        $syear              = '';
        $syearformat        = '';

        for ($k = 1; $k < 13; $k++) {
            $month = date('m', strtotime("+$k month"));
            $gety  = date('y', strtotime("+$k month"));

            if ($gety == $numbery) {
                $syear       = $prevyear;
                $syearformat = $prevyearformat;
            } else {
                $syear       = $numbery;
                $syearformat = $year;
            }

            $monthly        = $this->home_model->monthlysaleamount($syearformat, $month);
            $odernum        = $this->home_model->monthlysaleorder($syearformat, $month);
            $monthlyonline  = $this->home_model->onlinesaleamount($syearformat, $month);
            $odernumonline  = $this->home_model->onlinesaleorder($syearformat, $month);
            $monthlyoffline = $this->home_model->offlinesaleamount($syearformat, $month);
            $odernumoffline = $this->home_model->offlinesaleorder($syearformat, $month);

            $salesamount .= $monthly . ', ';
            $totalorder .= $odernum . ', ';

            $salesamountonline .= $monthlyonline . ', ';
            $totalorderonline .= $odernumonline . ', ';
            $salesamountoffline .= $monthlyoffline . ', ';
            $totalorderoffline .= $odernumoffline . ', ';
            $months .= date('F-' . $syear, strtotime("+$k month")) . ',';
        }

        $monthlysaleamount = trim($salesamount, ',');
        $monthlysaleorder  = trim($totalorder, ',');
        $onlinesaleamount  = trim($salesamountonline, ',');
        $onlinesaleorder   = trim($totalorderonline, ',');
        $offlinesaleamount = trim($salesamountoffline, ',');
        $offlinesaleorder  = trim($totalorderoffline, ',');

        $monthname = trim($months, ',');

        $data['chartinfo'] = $allbasicinfo;
        header('Content-Type: text/javascript');
        echo ('window.chartinfo = {"monthlysaleamount":"' . trim($monthlysaleamount, ', ') . '",monthlysaleorder:"' . trim($monthlysaleorder, ', ') . '","onlinesaleamount":"' . trim($onlinesaleamount, ', ') . '","onlinesaleorder":"' . trim($onlinesaleorder, ', ') . '","offlinesaleamount":"' . trim($offlinesaleamount, ', ') . '","offlinesaleorder":"' . trim($offlinesaleorder, ', ') . '","monthname":' . "'" . trim($monthname, ', ') . "'" . '};');
        exit();
    }

    public function checkmonth()
    {
        $monyhyear   = $this->input->post('monthyear');
        $getmonth    = date('m', strtotime($monyhyear));
        $totalmonth  = $getmonth + 1;
        $year        = date('Y', strtotime($monyhyear));
        $months      = '';
        $salesamount = '';
        $totalorder  = '';
        $numbery     = date('y', strtotime($monyhyear));
        $yformat     = date('Y', strtotime($monyhyear));
        $year        = date('Y');
        $numbery     = date('y');

        $prevyear       = $numbery - 1;
        $prevyearformat = $year - 1;
        $syear          = '';
        $syearformat    = '';
        $d              = (int) $getmonth;

        for ($d = $totalmonth; $d < 13; $d++) {
            $month = date('m', strtotime("+$d month"));
            $gety  = date('y', strtotime("+$d month"));

            if ($gety == $numbery) {
                $syear       = $prevyear;
                $syearformat = $prevyearformat;
            } else {
                $syear       = $prevyear;
                $syearformat = $prevyearformat;
            }

            $monthly = $this->home_model->monthlysaleamount($year, $month);
            $odernum = $this->home_model->monthlysaleorder($year, $month);
            $salesamount .= $monthly . ', ';
            $totalorder .= $odernum . ', ';
            $months .= date('F-' . $syear, strtotime("+$d month")) . ',';
        }

        for ($k = 1; $k < $totalmonth; $k++) {
            $month = date('m', strtotime("+$k month"));
            $gety  = date('y', strtotime("+$k month"));

            if ($gety == $numbery) {
                $syear       = $prevyear;
                $syearformat = $prevyearformat;
            } else {
                $syear       = $numbery;
                $syearformat = $yformat;
            }

            $monthly = $this->home_model->monthlysaleamount($syearformat, $month);
            $odernum = $this->home_model->monthlysaleorder($syearformat, $month);
            $salesamount .= $monthly . ', ';
            $totalorder .= $odernum . ', ';
            $months .= date('F-' . $syear, strtotime("+$k month")) . ',';
        }

        $data["monthlysaleamount"] = trim($salesamount, ',');
        $data["monthlysaleorder"]  = trim($totalorder, ',');
        $data["monthname"]         = trim($months, ',');

        $data['module'] = "dashboard";
        $data['page']   = "home/searchchart";
        $this->load->view('dashboard/home/searchchart', $data);
    }

    public function profile()
    {
        $data['title']  = "Profile";
        $data['module'] = "dashboard";
        $data['page']   = "home/profile";
        $id             = $this->session->userdata('id');
        $data['user']   = $this->home_model->profile($id);
        echo Modules::run('template/layout', $data);
    }

    public function setting()
    {
        $data['title'] = display('profile_setting');
        $id            = $this->session->userdata('id');
        /*-----------------------------------*/
        $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[50]|alpha_numeric_spaces');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[50]|alpha_numeric_spaces');
        #------------------------#
        $this->form_validation->set_rules('email', 'Email Address', "required|valid_email|max_length[100]");

        #------------------------#
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]|md5');
        $this->form_validation->set_rules('about', 'About', 'max_length[1000]');
        /*-----------------------------------*/
        $config['upload_path']   = './assets/img/user/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $data  = $this->upload->data();
            $image = $config['upload_path'] . $data['file_name'];

            $config['image_library']  = 'gd2';
            $config['source_image']   = $image;
            $config['create_thumb']   = false;
            $config['maintain_ratio'] = true;
            $config['width']          = 115;
            $config['height']         = 90;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->session->set_flashdata('message', "Image Upload Successfully!");
        }

        /*-----------------------------------*/
        $data['user'] = (object) $userData = [
            'id'        => $this->input->post('id'),
            'firstname' => $this->input->post('firstname', true),
            'lastname'  => $this->input->post('lastname', true),
            'email'     => $this->input->post('email', true),
            'password'  => md5($this->input->post('password') ?? ''),
            'about'     => $this->input->post('about', true),
            'image'     => (!empty($image) ? $image : $this->input->post('old_image', true)),
        ];

        /*-----------------------------------*/
        if ($this->form_validation->run()) {

            if (empty($userData['image'])) {
                $this->session->set_flashdata('exception', $this->upload->display_errors());
            }

            if ($this->home_model->setting($userData)) {

                $this->session->set_userdata([
                    'fullname' => $this->input->post('firstname', true) . ' ' . $this->input->post('lastname', true),
                    'email'    => $this->input->post('email', true),
                    'image'    => (!empty($image) ? $image : $this->input->post('old_image')),
                ]);

                $this->session->set_flashdata('message', display('update_successfully'));
            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));
            }

            redirect("dashboard/home/setting");
        } else {
            $data['module'] = "dashboard";
            $data['page']   = "home/profile_setting";
            if (!empty($id)) {
                $data['user'] = $this->home_model->profile($id);
            }

            echo Modules::run('template/layout', $data);
        }
    }
}
