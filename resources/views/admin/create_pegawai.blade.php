@extends('layouts._AdmTempelate')

@section('content')
    <div class="row">
        <div class="col-lg-12">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tambah Pegawai</h3>
                        <p class="panel-subtitle">Pegawai Control Panel</p>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-8 col-lg-offset-2">
                            <form action="" method="post">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-lg-4 col-form-label">Nama Pegawai</label>
                                        <div class="col-lg-8">
                                            <select id="nama_pegawai" name="nama_pegawai" class="form-control">
                                                <option selected>-- Pilih Pegawai --</option>
                                                <option>...</option>
                                            </select>
                                            <input type="hidden" class="form-control" id="id_pegawai" name="id_pegawai" value="">
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-lg-4 col-form-label">Username</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-lg-4 col-form-label">Email</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="email" name="email" placeholder="email@example.com">
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-lg-4 col-form-label">Password</label>
                                        <div class="col-lg-8">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-lg-4 col-form-label">Ulangi Password</label>
                                        <div class="col-lg-8">
                                            <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Password">
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-lg-4 col-form-label">User Role</label>
                                        <div class="col-lg-8">
                                            <select id="nama_pegawai" name="role" class="form-control">
                                                <option selected>-- Pilih Role --</option>
                                                <option>...</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-lg-4 col-form-label"></label>
                                        <div class="col-lg-8">
                                            <button type="reset" class="btn btn-default">Reset</button>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                </div>                                
                                <div class="row">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>   
@endsection