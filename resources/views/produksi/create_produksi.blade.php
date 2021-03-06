@extends('layouts._GdgTempelate')

@section('content')
<h3 class="page-title">Tambah Produk</h3>
<div class="row">
        <div class="col-md-12">
                <!-- PANEL HEADLINE -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Form Tambah Produk</h3>
                    @if (session('status'))
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <i class="fa fa-info-circle"></i>{{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="panel-body">
                    <form action="{{'/produksi'}}" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Produk</label>
                                    <div class="col-lg-9">
                                        @csrf
                                        <select class="form-control" name="id_produk">
                                            @foreach ($produk_data as $produk)
                                                <option value="{{$produk->id}}">{{$produk->product_name}}</option>                                                
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Jumlah Produksi</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="text" name="jml_produksi" placeholder="Jumlah Produksi" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <input type="submit" class="btn btn-primary" value="Simpan">
                                        <input type="reset" class="btn btn-secondary" value="Cancel">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END PANEL HEADLINE -->
        </div> 
</div>  
@endsection