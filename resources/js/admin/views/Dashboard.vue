<template>
    <section>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>  
        <!-- ./row -->

        <!-- /.content-header -->    
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 v-if="divisa">{{  divisa | currency }}</h3>    
                        <h3 v-else>{{  0 | currency }}</h3>    
                        <!-- <h3>190.000,00</h3> -->
                        <p>Cotización del Dolar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign fa-5x"></i>
                    </div>
                    <router-link :to="{name: 'divisas'}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></router-link>
                    <!-- <a href="{{ route('divisa.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Ventas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line fa-5x"></i>
                </div>
                <a href="#" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Usuarios Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus fa-5x"></i>
                    </div>
                <a href="#" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>65</h3>
                        <p>Inventario</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-pie fa-5x"></i>
                    </div>
                    <a href="#" class="small-box-footer">Mas Inventario <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- ./row -->

        <!-- Gráficos -->
        <div class="row">
            <section class="col-md-6 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                <a class="nav-link active" href="#sales-chart" data-toggle="tab">Ventas</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#income-chart" data-toggle="tab">Compras</a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="sales-chart" style="position: relative;">
                            <canvas id="chart_sale"></canvas>
                        </div>
                        <div class="chart tab-pane" id="income-chart" style="position: relative;">
                            <canvas id="chart_income"></canvas>
                        </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </section>
            <!-- ./section -->
            <section class="col-md-6 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Pendientes</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#sales-chart2" data-toggle="tab">Pagados</a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                                <canvas id="chart_sale_1"></canvas>
                            </div>
                            <div class="chart tab-pane" id="sales-chart2" style="position: relative;">
                                <canvas id="chart_income_2"></canvas>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </section>
            <!-- ./section -->
        </div>
        <!-- ./row -->
    </section>
</template>

<script>

$("body").removeClass("login-page");
$("body").addClass("sidebar-mini");

export default {
    mounted(){
        this.getData();
    },
    data(){
        return {
            divisa: 0,
            sales:[],
            varSale: null,
            chartSale: null,
            monthSale: [],
            totalSale: [],
            incomes:[],
            varIncome: null,
            chartIncome: null,
            monthIncome: [],
            totalIncome: [],
        }
    },
    methods: {
        start () {
            this.$Progress.start()
        },
        getData(){
            let me = this;
            var url = "/api/auth/dashboard";
            this.$Progress.start()
            axios.get(url).then(response => {
                console.log(response.data.divisa_p)
                me.divisa = response.data.divisa_p;
                me.sales = response.data.sales;
                me.incomes = response.data.incomes;
                me.loadSales(me.sales);
                me.loadSales_1(me.incomes);
                me.loadIncomes(me.incomes);
                me.loadIncomes_2(me.sales);
                this.$Progress.finish()
            }).catch(errors => {
                console.log(errors)
                this.$Progress.fail()
            });
        },
        loadSales(){
            let me = this;
                me.sales.map(function(sale){
                me.monthSale.push(sale.monthname); 
                me.totalSale.push(sale.sum); 
                // console.log(me.monthSale)
            });

            me.varSale = document.getElementById('chart_sale').getContext('2d');

            me.chartSale = new Chart(me.varSale, {
                type: 'bar',
                data: {
                    labels: me.monthSale,
                    datasets: [{
                        label: 'Ventas',
                        data: me.totalSale,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        loadSales_1(){
            let me = this;
                me.sales.map(function(sale){
                me.monthSale.push(sale.monthname); 
                me.totalSale.push(sale.sum); 
                // console.log(me.monthSale)
            });

            me.varSale = document.getElementById('chart_sale_1').getContext('2d');

            me.chartSale = new Chart(me.varSale, {
                type: 'bar',
                data: {
                        datasets: [{
                            label: 'Bar Dataset',
                            data: [10, 20, 30, 40]
                        }, {
                            label: 'Cantidad',
                            data: [40, 30, 70, 30],
                            backgroundColor: [ 'rgba(153, 102, 255, 1)'],   
                            // Changes this dataset to become a line
                            type: 'line'
                        }],
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril']
                    },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        loadIncomes(){
            let me = this;
                me.incomes.map(function(income){
                me.monthIncome.push(income.monthname); 
                me.totalIncome.push(income.sum); 
                console.log(me.totalIncome)
            });

            me.varIncome = document.getElementById('chart_income').getContext('2d');

            me.chartIncome = new Chart(me.varIncome, {
                type: 'line',
                data: {
                    labels: me.monthIncome,
                    datasets: [{
                        label: 'Compras',
                        data: me.totalIncome,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                            
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        loadIncomes_2(){
            let me = this;
                me.incomes.map(function(income){
                me.monthIncome.push(income.monthname); 
                me.totalIncome.push(income.sum); 
                console.log(me.totalIncome)
            });

            me.varIncome = document.getElementById('chart_income_2').getContext('2d');

            me.chartIncome = new Chart(me.varIncome, {
                type: 'pie',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: 'Pagados',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: [
                            'rgba(153, 102, 255, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 159, 64, 1)'
                            
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
    }
    
}
</script>
