<template>
    <div class="container pt-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-muted">
                    <i class="fas fa-address-card"> </i>
                    <strong>{{data.name}}</strong>
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                        </tr>
                    </thead>
                    <tbody class="text-muted">
                        <tr>
                            <th width=300>RIF/CI:</th>
                            <td>{{ data.type_document + "-" + data.num_document }}</td>
                        </tr>
                        <tr>
                            <th width=300>N° Teléfono:</th>
                            <td v-text="data.num_phone"></td>
                        </tr>
                        <tr>
                            <th width=300>Correo Electrónico</th>
                            <td v-text="data.email"></td>
                        </tr>
                        <tr>
                            <th width=300>Dirección</th>
                            <td v-text="data.address"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data']
}
</script>