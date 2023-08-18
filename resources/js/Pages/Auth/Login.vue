<script setup>
import {useForm} from "@inertiajs/vue3";
import Swal from "sweetalert2";

const form = useForm({
    email:'',
    password:''
})
function login(){
    form.post('/login',{
        preserveScroll:true,
        onSuccess: (response)=>{
            let icon, text;
            if (response.props.flash.success){
                 icon = 'success';
                text = response.props.flash.success;
            }else{
                 icon = 'error';
                text = response.props.flash.error;
            }
            Swal.fire({
                title: 'Login!',
                text: text,
                icon: icon,
                confirmButtonText: 'Tutup'
            });
        },
    });
}
</script>

<template>
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
        <div class="col-lg-6">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                </div>
                <form class="user" @submit.prevent="login">
                    <div class="form-group">
                        <input v-model="form.email" type="email" class="form-control form-control-user"
                               id="email" aria-describedby="emailHelp"
                               placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                        <input v-model="form.password" type="password" class="form-control form-control-user"
                               id="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Login
                    </button>
                    <hr>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
