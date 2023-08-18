<template>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Parkir <sup>app</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#parkir-menu"
               aria-expanded="true" aria-controls="parkir-menu">
                <i class="fas fa-fw fa-cog"></i>
                <span>Parkir</span>
            </a>
            <div id="parkir-menu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <Link class="collapse-item" :href="`/parkir/masuk`">Masuk</Link>
                    <Link class="collapse-item" :href="`/parkir/keluar`">Keluar</Link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#master-menu"
               aria-expanded="true" aria-controls="master-menu">
                <i class="fas fa-fw fa-cog"></i>
                <span>Data</span>
            </a>
            <div id="master-menu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <Link class="collapse-item" :href="`/master/kategori`">Kategori</Link>
                </div>
            </div>
        </li>
    </ul>
</template>
<script setup>
</script>
