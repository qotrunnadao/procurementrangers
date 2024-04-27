<div class="modal fade" id="addvendor" tabindex="-1" role="dialog" aria-labelledby="ModalvendorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalvendorLabel">Tambah Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{Form::open(array('route'=>'master.vendor.store','method'=>'post'))}}
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Kode vendor</label>
                            <input type="text" class="form-control" id="kode_vendor" name="kode_vendor" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama Vendor</label>
                            <input type="text" class="form-control" id="nama_vendor" name="nama_vendor" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Alamat Vendor</label>
                            <textarea type="text" class="form-control" id="alamat_vendor" name="alamat_vendor" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Telepon</label>
                            <input type="telepon" class="form-control" id="telepon" name="telepon" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Bank</label>
                            <select id="id_bank" name="id_bank" class="form-control select2">
                                <option value="">Pilih Bank</option>
                                @foreach ($banks as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_bank }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nomor Rekening</label>
                            <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                    <button type="submit" class="btn btn-success" id="save">Save</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>