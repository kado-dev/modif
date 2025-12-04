<h3 class="judul"><b>Tindakan (Planning)</b></h3>
<div class="table-responsive">
    <table class="table-judul" width="100%">
        <tr>
            <td class="col-sm-6">
                <input type="text" class="form-control tindakanbpjs inputan" placeholder="Ketikan Nama Tindakan">
                <input type="hidden" class="form-control idtindakanbpjs">
                <input type="hidden" class="form-control namatindakanbpjs">
            </td>
            <td class="col-sm-2"><input type="text" name="biayabpjs" class="form-control tariftindakanbpjs inputan" placeholder="0"></td>
            <td class="col-sm-4"><input type="text" name="keteranganbpjs" class="form-control keteranganbpjs inputan" placeholder="Ketikan keterangan tambahan jika dipelukan"></td>
            <td><button type="button" class="btn btn-round btn-success tambah-tindakan-bpjs"><i class="fa fa-plus"></i></button></td>
        </tr>
    </table>
</div>
<br/>
<div class="table-responsive">
    <table class="table-judul">
        <!-- buat simpan data sementara -->
        <thead>
            <tr class="head-table-tindakan-bpjs">
                <th width="50%">Tindakan</th>
                <th width="10%">Biaya</th>
                <th width="20%">Keterangan</th>
                <th width="10%">#</th>
            </tr>
        </thead>
        <tbody>
            <tr class="master-table-tindakan-bpjs" style="display:none">
                <input type="hidden" class="idtindakanbpjs-input">
                <input type="hidden" class="namatindakanbpjs-input">
                <input type="hidden" class="tariftindakanbpjs-input">
                <input type="hidden" class="keteranganbpjs-input">
                <td style="padding: 5px; text-align: left;" class="namatindakanbpjs-html"></td>
                <td style="padding: 5px; text-align: right;" class="tariftindakanbpjs-html"></td>
                <td style="padding: 5px; text-align: left;" class="keteranganbpjs-html"></td>
                <td style="padding: 5px; text-align: center;"><button class="btn btn-round btn-danger hapus-tindakan-bpjs"><i class="fas fa-trash-alt"></i></button></td>
            </tr>
        </tbody>
    </table>
</div>