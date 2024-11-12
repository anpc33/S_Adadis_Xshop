<?php

class DonHangController
{

  // Kết nối model DonHang
  public $modelDonHang;

  public function __construct()
  {
    $this->modelDonHang = new DonHang();
  }

  // Liệt kê tất cả đơn hàng
  public function listDonHang()
  {
    $donHang = $this->modelDonHang->getAll();  // Lấy tất cả đơn hàng

    // Chuyển kết quả đến view
    require_once './views/DonHang/listDonHang.php';
  }

  // Tìm kiếm đơn hàng theo mã và trạng thái
  public function searchDonHang()
  {

    // var_dump($_POST);
    // Lấy các tham số từ POST thay vì GET
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    // Gọi model để tìm kiếm đơn hàng
    $donHang = $this->modelDonHang->searchOrders($search, $status);




    // Hiển thị kết quả tìm kiếm
    require_once './views/DonHang/listDonHang.php';
  }

  // Xử lý xóa
  public function Delete()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['id_don_hang'];
      // var_dump($id);

      $deleteDonHang = $this->modelDonHang->deleteDonHang($id);
      // echo'them thna ckgn';
      header('Location: ?act=don-hang'); // Sửa lại khoảng trắng
      exit();
    }
  }


  public function ShowUpdate()
  {

    $id = $_GET['id_don_hang'];
    $donHangShow = $this->modelDonHang->donHangShow($id);

    // var_dump($danhMucw);
    require_once './views/DonHang/updateDonHang.php';
  }


  // Xử lý logic update
  public function handleUpdate()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $id = $_POST['id'];
      $trang_thai = $_POST['trang_thai'];

      // var_dump($trang_thai);

      //Validate
      $Error = [];
      if (empty($trang_thai)) {
        $Error['trang_thai'] = 'Trạng thái là bắt buộc';
      }

      if (empty($Error)) {
        $this->modelDonHang->updateDonHang($id, $trang_thai);
        unset($_SESSION['Error']);
        // Thêm đoạn mã HTML và JavaScript để hiển thị thông báo
        // echo "Thêm thành công";
        header('Location: ?act=don-hang');
        exit();
      } else {
        $_SESSION['Error'] = $Error;
        header('Location: ?act=form-sua-don-hang'); // Sửa lại khoảng trắng
        exit();
      }
    }
  }
}
