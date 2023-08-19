<script setup>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-responsive';
import {router, useForm} from "@inertiajs/vue3";
import Swal from "sweetalert2";

DataTable.use(DataTablesCore);
function toEdit (category){
    form.id = category.id
    form.name = category.name
    form.charge = category.charge
}
function toCreate()
{
    form.reset()
}
const form = useForm({
    name:'',
    charge:'',
    id:'',
})
function toDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.visit(`/master/kategori/${id}`,{
                method:'delete',
                onSuccess: function (response){
                    let icon,text;
                   if (response.props.flash.success)
                   {
                       icon = 'success';
                       text = response.props.flash.success;
                   }else{
                       icon = 'error';
                       text = response.props.flash.error;
                   }
                    Swal.fire(
                        {
                            title: 'Hapus!',
                            text: text,
                            icon: icon,
                            confirmButtonText: 'Tutup'
                        }
                    )
                }
            })
        }
    })
}

const submitForm = function (){
    form.post('/master/kategori',{
        preserveScroll:true,
        onSuccess:function (response){
            let icon,text;
            form.reset();
            $('#modal-create').modal('hide');
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
            router.get('/master/kategori');
        }
    });
}

defineProps({
    categories:'',
    errors:''
})
</script>
<template>
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row mb-2">
                <div class="col d-flex align-items-start flex-column">
                    <h5 class="m-0 font-weight-bold text-primary">Kategori</h5>
                </div>
                <div class="col d-flex align-items-end flex-column">
                    <button type="button" class="btn btn-primary" @click="toCreate()" data-toggle="modal" data-target="#modal-create">
                        Tambah
                    </button>
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
                        <th scope="col">Nama</th>
                        <th scope="col">Tarif/Jam</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tarif/Jam</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr v-for="(category, index) of categories">
                        <td style="width: 10%">{{index+1}}</td>
                        <td style="width: 50%">{{category.name}}</td>
                        <td style="width: 30%">{{category.charge}}</td>
                        <td style="width: 10%">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a href="javascript:void(0)" class="dropdown-item" @click="toEdit(category)" data-name="{{category.name}}" data-toggle="modal" data-target="#modal-create">Edit</a>
                                        <a href="javascript:void(0)" class="dropdown-item" @click="toDelete(category.id)">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </DataTable>
            </div>
        </div>
    </div>
<!--    MODAL-->

    <!-- Modal -->
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="submitForm">
                    <input v-model="form.id" id="id" type="hidden">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input v-model="form.name" type="text" class="form-control" id="name" aria-describedby="nama" placeholder="Masukkan Nama">
                            <small v-if="errors.name" id="nama" class="form-text text-danger">{{errors.name}}</small>
                    </div>
                    <div class="form-group">
                        <label for="name">Tarif</label>
                        <input v-model="form.charge" type="number" class="form-control" id="charge" aria-describedby="tarif" placeholder="Masukkan Tarif">
                        <small v-if="errors.charge" id="nama" class="form-text text-danger">{{errors.charge}}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>
<style>
@import 'datatables.net-dt';
</style>
