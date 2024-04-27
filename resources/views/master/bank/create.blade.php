<div class="modal fade" id="addbank" tabindex="-1" role="dialog" aria-labelledby="ModalBankLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalBankLabel">Tambah Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{Form::open(array('route'=>'master.bank.store','method'=>'post'))}}
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama Bank</label>
                            <input type="text" class="form-control" id="nama_bank" name="nama_bank" placeholder="Masukkan Nama Bank" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Kode Bank</label>
                            <input type="text" class="form-control" id="kode_bank" name="kode_bank" placeholder="Masukkan kode Bank" required>
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