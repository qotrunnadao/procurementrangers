<div class="modal fade" id="addbarang" tabindex="-1" role="dialog" aria-labelledby="ModalbarangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalbarangLabel">Tambah barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{Form::open(array('route'=>'master.barang.store','method'=>'post'))}}
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Kode item</label>
                            <input type="text" class="form-control" id="kode_item" name="kode_item" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama Item</label>
                            <input type="text" class="form-control" id="nama_item" name="nama_item" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Available Date</label>
                            <input type="date" class="form-control" id="available_date" name="available_date" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Harga Item</label>
                            <input type="text" class="form-control money" id="harga_item" name="harga_item" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Berat (Kg)</label>
                            <input type="text" class="form-control" id="berat_kg" name="berat_kg" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Kategori</label>
                            <select id="id_kategori" name="id_kategori" class="form-control select2">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoris as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
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