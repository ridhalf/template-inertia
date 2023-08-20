<script setup>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-responsive';
import {router, useForm} from "@inertiajs/vue3";
import Swal from "sweetalert2";
DataTable.use(DataTablesCore);

defineProps({
    parkir : Object,
    categories: Object,
    errors: Object
})
const form = useForm({
    no_police:'',
    category_id:''
})
function saveParkir()
{
    form.post('/parkir/check_in',{
        preserveScroll:true,
        onSuccess:function (response){
            let icon,text;
            form.reset();
            if (response.props.flash.success){
                icon = 'success';
                text = response.props.flash.success;
            }else{
                icon = 'error';
                text = response.props.flash.error;
            }
            Swal.fire({
                title: 'Simpan!',
                text: text,
                icon: icon,
                confirmButtonText: 'Tutup'
            })
            router.get('/parkir/masuk');
        }
    })
}

</script>
<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row mb-2">
                <div class="col">
                    <h5 class="btn btn-outline-primary font-weight-bold" data-toggle="collapse" href="#collapse-checkin" role="button" aria-expanded="false" aria-controls="collapse-checkin">Tambah</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="collapse multi-collapse" id="collapse-checkin">
                <form @submit.prevent="saveParkir">
                    <div class="d-flex flex-row">
                        <div class="p-2">
                            <label for="no_policie" class="col-form-label">No Polisi</label>
                        </div>
                        <div class="p-2">
                            <input v-model="form.no_police" type="text" class="form-control" placeholder="Masukkan no polisi">
                            <small v-if="errors.no_police" class="text-danger">{{errors.no_police}}</small>
                        </div>
                        <div class="p-2">
                            <label for="category" class="col-form-label">Kategori</label>
                        </div>
                        <div class="p-2">
                                <select v-model="form.category_id" id="inputState" class="form-control pr-5">
                                    <option selected>Pilih Kategori</option>
                                    <option v-for="category of categories" :value="category.id">{{category.name}}</option>
                                </select>
                            <small v-if="errors.category_id" class="text-danger">{{errors.category_id}}</small>
                        </div>
                        <div class="p-2">
                            <button type="submit" class="form-control ml-4 btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row mb-2">
                <div class="col d-flex align-items-start flex-column">
                    <h5 class="m-0 font-weight-bold text-primary">Masuk</h5>
                </div>
            </div>
            <!-- Button trigger modal -->
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <DataTable  class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Parkir</th>
                        <th scope="col">No Polisi</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Kategori</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Parkir</th>
                        <th scope="col">No Polisi</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Kategori</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr v-for="(data, index) of parkir">
                        <td>{{index+1}}</td>
                        <td>{{data.parking_code}}</td>
                        <td>{{data.no_police}}</td>
                        <td>{{data.check_in}}</td>
                        <td>{{data.category_name}}</td>
                    </tr>
                    </tbody>
                </DataTable>
            </div>
        </div>
    </div>
</template>
<style>
@import 'datatables.net-dt';
</style>
