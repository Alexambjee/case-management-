<template>
        <!-- navbar -->
        <div id="layoutSidenav">
            <!-- sidebar -->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="text-center mt-4">
                                    <img class="mb-4 img-error" src="../../../public/images/error-404-monochrome.svg" />
                                    <p class="lead">This requested URL was not found on this server.</p>
                                    <div v-if="dtdUser">
                                        <span>
                                            <i class="fas fa-arrow-left me-1"></i>
                                            <router-link v-if="dtdUser" :to="dtdUser.PRIMARY_PATH">Return to Dashboard</router-link>
                                        </span>
                                    </div>
                                    <div v-else>

                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                          
                        
                    </div>
                </main>

      </div>
    </div>
    
</template>

