<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <title>Bootstrap Example</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <style>
      .fa,
      .fas {
         color: #858585;
      }

      .fa-folder {
         color: rgb(74, 158, 255);
      }

      i.fa,
      table i.fas {
         font-size: 16px;
         margin-right: 6px;
      }

      i.action {
         cursor: pointer;
      }

      a {
         color: black;
      }
   </style>
</head>

<body>
   <?php
   function filesize_formatted($path)
   {
      $size = filesize($path);
      $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
      $power = $size > 0 ? floor(log($size, 1024)) : 0;
      return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
   }
   ?>

   <?php
   // go back to login
   if (isset($_SESSION['user']) == null && isset($_SESSION['pass']) == null) {
      $domain = dirname($_SERVER['REQUEST_URI']);
      header("Location: {$domain}/login.php");
   }
   ?>

   <?php
   $directory = 'D:';
   $directory = 'D:\xampp\htdocs';
   ?>
   <div class="container">
      <div class="row align-items-center py-5">
         <div class="col-6">
            <h3>
               File Manager
            </h3>
         </div>
         <div class="col-6">
            <h5 class="text-right">
               Xin chào User,
               <a class="text-primary" href="./logout.php">Logout</a>
            </h5>
         </div>
      </div>

      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="#">Home</a></li>
         <li class="breadcrumb-item"><a href="#">Products</a></li>
         <li class="breadcrumb-item active">Accessories</li>
      </ol>

      <div class="input-group mb-3">
         <div class="input-group-prepend">
            <span class="input-group-text">
               <span class="fa fa-search"></span>
            </span>
         </div>
         <input oninput="search(this)" type="text" class="search form-control" placeholder="Search">
      </div>

      <div class="btn-group my-3">
         <button onclick="createFolder(this)" type="button" class="btn btn-light border">
            <i class="fas fa-folder-plus"></i> New folder
         </button>
         <button onclick="createFile(this)" type="button" class="btn btn-light border">
            <i class="fas fa-file"></i> Create text file
         </button>
      </div>

      <!-- table show -->
      <table class="table table-hover border">
         <thead>
            <tr>
               <th>Name</th>
               <th>Type</th>
               <th>Size</th>
               <th>Last modified</th>
               <th>Actions</th>
            </tr>
         </thead>

         <tbody>
            <?php
            function show($directory, $list)
            {
               // print_r(scandir($directory));
               $listDirectory = $list;

               foreach ($listDirectory as $key => $value) {
                  // echo "$key -> $directory\\$value";
                  $path = "$directory\\$value";
                  if (is_dir($path)) {
                     echo "
                     <tr>
                        <td>
                           <i class='fa fa-folder'></i>
                           <a href='#'>$value</a>
                        </td>
                        <td>Folder</td>
                        <td>" . filesize_formatted($path) . "</td>
                        <td>" . date("d/m/Y H:i A", filemtime($path)) . "</td>
                        <td>
                           <span onclick=''><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  ";
                  } else if (is_file($path)) {
                     if (strpos($path, '.rar') !== false || strpos($path, '.zip') || strpos($path, '.7z')) {
                        echo "
                     <tr>
                        <td>
                           <i class='fa fa-archive'></i>
                           <a href='#'>$value</a>
                        </td>
                        <td>Compressed file</td>
                        <td>" . filesize_formatted($path) . "</td>
                        <td>" . date("d/m/Y H:i A", filemtime($path)) . "</td>
                        <td>
                           <span><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  ";
                     } else if (strpos($path, '.ico') !== false || strpos($path, '.png') || strpos($path, '.jpg')) {
                        echo "
                     <tr>
                        <td>
                           <i class='fa fa-file-image'></i>
                           <a href='#'>$value</a>
                        </td>
                        <td>Image</td>
                        <td>" . filesize_formatted($path) . "</td>
                        <td>" . date("d/m/Y H:i A", filemtime($path)) . "</td>
                        <td>
                           <span><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  ";
                     } else if (strpos($path, '.mp3') !== false || strpos($path, '.wma') || strpos($path, '.wav')) {
                        echo "
                     <tr>
                        <td>
                           <i class='fa fa-file-audio'></i>
                           <a href='#'>$value</a>
                        </td>
                        <td>Music</td>
                        <td>" . filesize_formatted($path) . "</td>
                        <td>" . date("d/m/Y H:i A", filemtime($path)) . "</td>
                        <td>
                           <span><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  ";
                     } else if (strpos($path, '.doc') !== false || strpos($path, '.docx')) {
                        echo "
                     <tr>
                        <td>
                           <i class='fa fa-file-word'></i>
                           <a href='#'>$value</a>
                        </td>
                        <td>Word</td>
                        <td>" . filesize_formatted($path) . "</td>
                        <td>" . date("d/m/Y H:i A", filemtime($path)) . "</td>
                        <td>
                           <span><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  ";
                     } else if (strpos($path, '.pdf') !== false) {
                        echo "
                     <tr>
                        <td>
                           <i class='fa fa-file-pdf'></i>
                           <a href='#'>$value</a>
                        </td>
                        <td>PDF</td>
                        <td>" . filesize_formatted($path) . "</td>
                        <td>" . date("d/m/Y H:i A", filemtime($path)) . "</td>
                        <td>
                           <span><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  ";
                     } else if (strpos($path, '.mp4') !== false || strpos($path, '.avi') || strpos($path, '.mkv')) {
                        echo "
                     <tr>
                        <td>
                           <i class='fa fa-file-video'></i>
                           <a href='#'>$value</a>
                        </td>
                        <td>Video</td>
                        <td>" . filesize_formatted($path) . "</td>
                        <td>" . date("d/m/Y H:i A", filemtime($path)) . "</td>
                        <td>
                           <span><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  ";
                     } else if (strpos($path, '.php') !== false || strpos($path, '.html') || strpos($path, '.css')) {
                        echo "
                     <tr>
                        <td>
                           <i class='fa fa-file-code'></i>
                           <a href='#'>$value</a>
                        </td>
                        <td>Code</td>
                        <td>" . filesize_formatted($path) . "</td>
                        <td>" . date("d/m/Y H:i A", filemtime($path)) . "</td>
                        <td>
                           <span><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  ";
                     } else {
                        echo "
                     <tr>
                        <td>
                           <i class='fa fa-file'></i>
                           <a href='#'>$value</a>
                        </td>
                        <td>Other</td>
                        <td>" . filesize_formatted($path) . "</td>
                        <td>" . date("d/m/Y H:i A", filemtime($path)) . "</td>
                        <td>
                           <span><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  ";
                     }
                  }
               }
            }
            ?>

            <?php
            $listDirectory = array_diff(scandir($directory), array('.', '..'));
            show($directory, $listDirectory);
            ?>
         </tbody>

      </table>

      <div class="border rounded mb-3 mt-5 p-3">
         <h4>File upload</h4>
         <form action="./home.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
               <div class="custom-file">
                  <input name="path" onchange="$('.custom-file-label').text($(this).val())" type="file" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile"></label>
               </div>
            </div>
            <p>Người dùng chỉ được upload tập tin có kích thước tối đa là 20 MB.</p>
            <p>Các tập tin thực thi (*.exe, *.msi, *.sh) không được phép upload.</p>
            <!-- <p><strong>Yêu cầu nâng cao</strong>: hiển thị progress bar trong quá trình upload.</p> -->
            <button name="upload" onclick="upload(this)" class="btn btn-success px-5">Upload</button>
         </form>

         <?php
         if (!empty($_FILES['path'])) {
            // $directory = $_POST['directory'];
            $path = $_FILES['path'];

            // echo $path['name'];
            // echo $path['type'];
            // echo $path['tmp_name'];
            // echo $path['error'];
            // echo $path['size'];
            echo move_uploaded_file($path['tmp_name'], $directory . '\\' . $path['name']);
            header("Refresh:0");
         } else {
         }

         ?>
      </div>

      <div class="modal-example my-5">
         <h4>Một số dialog mẫu</h4>
         <p>Nhấn vào để xem kết quả</p>
         <ul>
            <li>
               <a href="#" data-toggle="modal" data-target="#confirm-delete">
                  Confirm delete
               </a>
            </li>
            <li>
               <a href="#" data-toggle="modal" data-target="#confirm-rename">
                  Confirm rename
               </a>
            </li>
            <li>
               <a href="#" data-toggle="modal" data-target="#new-file-dialog">
                  New file dialog
               </a>
            </li>
            <li>
               <a href="#" data-toggle="modal" data-target="#message-dialog">
                  Message Dialog
               </a>
            </li>
         </ul>
      </div>

   </div>


   <!-- Delete dialog -->
   <div class="modal fade" id="confirm-delete">
      <div class="modal-dialog">
         <div class="modal-content">

            <div class="modal-header">
               <h4 class="modal-title">Xóa tập tin</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
               Bạn có chắc rằng muốn xóa tập tin <strong>image.jpg</strong>
            </div>

            <div class="modal-footer">
               <button onclick="remove()" type="button" class="btn btn-danger" data-dismiss="modal">Xóa</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
            </div>
         </div>
      </div>
   </div>



   <!-- Rename dialog -->
   <div class="modal fade" id="confirm-rename">
      <div class="modal-dialog">
         <div class="modal-content">

            <div class="modal-header">
               <h4 class="modal-title">Đổi tên</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
               <p>Nhập tên mới cho tập tin <strong></strong></p>
               <input type="text" placeholder="Nhập tên mới" value="" class="form-control" />
            </div>

            <div class="modal-footer">
               <button onclick="rename()" type="button" class="btn btn-primary" data-dismiss="modal">Lưu</button>
            </div>
         </div>
      </div>
   </div>

   <!-- New file dialog -->
   <div class="modal fade" id="new-file-dialog">
      <div class="modal-dialog">
         <div class="modal-content">

            <div class="modal-header">
               <h4 class="modal-title">Tạo tập tin mới</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
               <div class="form-group">
                  <label for="name">File Name</label>
                  <input type="text" placeholder="File name" class="form-control" id="name" />
               </div>
               <div class="form-group">
                  <label for="content">Nội dung</label>
                  <textarea rows="10" id="content" class="form-control" placeholder="Nội dung"></textarea>

               </div>
            </div>

            <div class="modal-footer">
               <button onclick="saveFile(this)" type="button" class="btn btn-success" data-dismiss="modal">Lưu</button>
            </div>
         </div>
      </div>
   </div>

   <!-- New folder dialog -->
   <div class="modal fade" id="new-folder-dialog">
      <div class="modal-dialog">
         <div class="modal-content">

            <div class="modal-header">
               <h4 class="modal-title">Tạo thư mục mới</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
               <div class="form-group">
                  <label for="name">Folder Name</label>
                  <input type="text" placeholder="Folder name" class="form-control" id="name" />
               </div>
            </div>

            <div class="modal-footer">
               <button onclick="saveFolder(this)" type="button" class="btn btn-success" data-dismiss="modal">Lưu</button>
            </div>
         </div>
      </div>
   </div>

   <!-- message dialog -->
   <div class="modal fade" id="message-dialog">
      <div class="modal-dialog">
         <div class="modal-content">

            <div class="modal-header">
               <h4 class="modal-title">Xóa file</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
               <p>Bạn không được cấp quyền để xóa tập tin/thư mục này</p>
            </div>

            <div class="modal-footer">
               <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
            </div>
         </div>
      </div>
   </div>


   <script>
      function upload(e) {
         $.ajax({
            type: "POST",
            url: 'http://localhost/web_basic/lab07/code%20templates/move.php',
            data: {
               path: `${directory}`,
               query: $('.search').val()
            },
            dataType: 'json',
            success: function(data) {},
            error: function(data) {}
         });
      }

      function search(e) {

         $.ajax({
            type: "POST",
            url: 'http://localhost/web_basic/lab07/code%20templates/search.php',
            data: {
               path: `${directory}`,
               query: $('.search').val()
            },
            dataType: 'json',
            success: function(data) {
               console.log("🚀 ~ file: home.php ~ line 464 ~ search ~ data", data);
               let table = $('table > tbody');
               table.empty();
               for (let index = 0; index < data.length; index++) {
                  const element = data[index];
                  table.html(table.html() + `
                  <tr>
                        <td>
                           <i class='fa fa-file'></i>
                           <a href='#'>${element}</a>
                        </td>
                        <td>Other</td>
                        <td></td>
                        <td></td>
                        <td>
                           <span><i class='fa fa-download action'></i></span>
                           <span onclick='edit(this)'><i class='fa fa-edit action'></i></span>
                           <span onclick='removeFile(this)'><i class='fa fa-trash action'></i></span>
                        </td>
                     </tr>
                  `);
               }
            },
            error: function(data) {
               console.log("🚀 ~ file: home.php ~ line 469 ~ search ~ data", data);
            }
         });
      }

      function saveFolder(e) {
         let modal = $('#new-folder-dialog').modal('show');
         let fileName = modal.find('input').val();

         $.ajax({
            type: "POST",
            url: 'http://localhost/web_basic/lab07/code%20templates/create.php',
            data: {
               path: `${directory}\\${fileName}`
            },
            dataType: 'json'
         });
         location.reload();
      }

      function createFolder(e) {
         let modal = $('#new-folder-dialog').modal('show');
      }

      function saveFile(e) {
         let modal = $('#new-file-dialog').modal('show');
         let fileName = modal.find('input').val();
         let content = modal.find('textarea').val();

         $.ajax({
            type: "POST",
            url: 'http://localhost/web_basic/lab07/code%20templates/create.php',
            data: {
               path: `${directory}\\${fileName}`,
               content: content
            },
            dataType: 'json'
         });
         location.reload();
      }

      function createFile(e) {
         let modal = $('#new-file-dialog').modal('show');
      }

      function removeFile(e) {
         let name = $($(e).parents()[1]).find('td:nth-child(1) a').text();

         let modal = $('#confirm-delete').modal('show');
         let fileName = modal.find('strong');
         fileName.text(name);
      }

      function remove() {
         let modal = $('#confirm-delete').modal('show');
         let fileName = modal.find('strong');

         $.ajax({
            type: "POST",
            url: 'http://localhost/web_basic/lab07/code%20templates/remove.php',
            data: {
               path: `${directory}\\${fileName.text()}`
            },
            dataType: 'json'
         });
         location.reload();
      }

      let directory = 'D:\\xampp\\htdocs';

      function rename() {
         let modal = $('#confirm-rename').modal('show');
         let fileName = modal.find('strong');
         let newName = modal.find('input');
         $.ajax({
            type: "POST",
            url: 'http://localhost/web_basic/lab07/code%20templates/rename.php',
            data: {
               path: `${directory}\\${fileName.text()}`,
               newName: `${directory}\\${newName.val()}`
            },
            dataType: 'json'
         });
         location.reload();
      }

      function edit(e) {
         let name = $($(e).parents()[1]).find('td:nth-child(1) a').text();

         let modal = $('#confirm-rename').modal('show');
         let fileName = modal.find('strong');
         let newName = modal.find('input');

         fileName.text(name);
         newName.val(name);

         console.log($($(e).parents()[1]).find('td>a'));
      }
   </script>
</body>

</html>