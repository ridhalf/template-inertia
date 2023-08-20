<script setup>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-responsive';
import {router, useForm} from "@inertiajs/vue3";
import Swal from "sweetalert2";
DataTable.use(DataTablesCore);
defineProps({
    errors:'',
    parkir:''
})
const form = useForm({
    parking_code:''
})
function check_out()
{
    form.post('/parkir/check_out',{
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
            router.get('/parkir/keluar');
        }
    })
}
</script>

<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row mb-2">
                <div class="col">
                    <h5 class="btn btn-outline-primary font-weight-bold" data-toggle="collapse" href="#collapse-checkin" role="button" aria-expanded="false" aria-controls="collapse-checkin">Keluar</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="collapse multi-collapse" id="collapse-checkin">
                <form @submit.prevent="check_out">
                    <div class="d-flex flex-row">
                        <div class="p-2">
                            <label for="parking_code" class="col-form-label">Kode Parkir</label>
                        </div>
                        <div class="p-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">PKR-</span>
                                </div>
                                <input v-model="form.parking_code"  type="text" class="form-control" placeholder="Masukkan kode parkir">
                            </div>
                            <small v-if="errors.parking_code" class="text-danger">{{errors.parking_code}}</small>
                        </div>
                        <div class="p-2">
                            <button type="submit" class="form-control ml-4 btn btn-primary">Simpan</button>
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
                    <h5 class="m-0 font-weight-bold text-primary">Keluar</h5>
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
                        <th scope="col">Jam Keluar</th>
                        <th scope="col">Durasi</th>
                        <th scope="col">Tarif</th>
                        <th scope="col">Kategori</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Parkir</th>
                        <th scope="col">No Polisi</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Jam Keluar</th>
                        <th scope="col">Durasi</th>
                        <th scope="col">Tarif</th>
                        <th scope="col">Kategori</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr v-for="(data,index) of parkir">
                        <td>{{index+1}}</td>
                        <td>{{data.parking_code}}</td>
                        <td>{{data.no_police}}</td>
                        <td>{{data.check_in}}</td>
                        <td>{{data.check_out}}</td>
                        <td>{{data.duration}} Jam</td>
                        <td>{{ "IDR " + data.total_payment.toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.")}}</td>
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
