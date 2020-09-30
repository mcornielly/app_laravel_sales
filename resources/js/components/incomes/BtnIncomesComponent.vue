<template>
    <div>
        <a href="#"
            title="ver"
            @click="click(data,'show')"
            class="btn btn-link btn-sm">
            <i class="fas fa-eye text-success" aria-hidden="true"></i>
        </a>

        <template>
            <a href="#"
                title="comprobante"
                @click="click(data,'pdf')"
                class="btn btn-link btn-sm">
                <i class="fas fa-file-invoice" aria-hidden="true"></i>
            </a>
        </template> 

       <template v-if="data.status=='REGISTRADO'">
            <a href="#"
                title="anular"
                @click="click(data,'delete')"
                class="btn btn-link btn-sm">
                <i class="fas fa-trash text-danger" aria-hidden="true"></i>
            </a>
        </template> 
    </div>
</template>

<script>
export default {
    props: {
        data: {},
        name: {},
        click: {},
        meta: {},
        classes: {},
    }  
}
</script>