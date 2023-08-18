<script setup>
import Sidebar from "./Partials/Sidebar.vue";
import Topbar from "./Partials/Topbar.vue";
import Footer from "./Partials/Footer.vue";

</script>
<template>
    <div id="wrapper">

        <!-- Sidebar -->
        <Sidebar/>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <Topbar/>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <slot/>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <Footer/>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
</template>
