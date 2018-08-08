<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="../css/datatables.min.css">
    <link rel="stylesheet" href="../css/cmn.css">
</head>

<body>
    <form>
        <div class="container-fluid">
            <div class="row">
                <div class="form-group col-12 col-sm-6 mb-2 mb-md-4">
                    <label for="txtGroupName" class="comet-required">グループ名</label>
                    <input type="text" class="form-control" id="txtGroupName">
                </div>
            </div>
        </div>
        <div class="mb-2 mb-md-4">
            <table id="users" class="table table-striped">
                <thead>
                    <tr>
                        <th>ユーザID</th>
                        <th>ユーザ名</th>
                        <th>所属</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>user_id-1</td>
                        <td>ユーザ名1</td>
                        <td><input type="checkbox" id="chkBelongs-user_id-1" selected></td>
                    </tr>
                    <tr>
                        <td>user_id-2</td>
                        <td>ユーザ名2</td>
                        <td><input type="checkbox" id="chkBelongs-user_id-2" selected></td>
                    </tr>
                    <tr>
                        <td>user_id-3</td>
                        <td>ユーザ名3</td>
                        <td><input type="checkbox" id="chkBelongs-user_id-3" selected></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-2 mb-md-4">
                    <a href="#" class="btn btn-primary px-3 px-sm-5" role="button">保存</a>
                    <a href="#" class="btn btn-secondary px-3 px-sm-5" role="button">中止</a>
                </div>
            </div>
        </div>
    </form>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/dataTables.min.js"></script>
    <script src="../js/cmn.js"></script>
    <script>
        //<![CDATA[
        $(document).ready(function() {
            $("#users").dataTable({});

            $('#users tr').click(function(e) {
                var chkBelongs = $(this).children('td').children('input[type=checkbox]');
                if (chkBelongs[0] == e.target) {
                    return;
                }

                if (chkBelongs.prop('checked')) {
                    chkBelongs.prop('checked', '');
                } else {
                    chkBelongs.prop('checked', 'checked');
                }
            })
        });
        //]]>
    </script>
</body>

</html>
