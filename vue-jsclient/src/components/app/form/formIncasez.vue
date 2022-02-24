<template>
    <validate-window ref="validateWindowRef"
                     :cWidth=500
                     :cHeight=200
                     :cTypeWindows=1
    ></validate-window>

    <validate-window ref="infoWindowRef"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=5
    ></validate-window>

    <validate-window ref="redWindowRef"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=6
    ></validate-window>

    <validate-window ref="refYesNo"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNo"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
            <!-- <div class="antet"> <div class="title">... test</div> </div> -->
        </template>
        <template v-slot:slotContent>
            <my-list
                    :ref = this.cfgtime.CFG_INVOICE_LIST.ref
                    :pConfig = this.cfgtime.CFG_INVOICE_LIST
            ></my-list>

        </template>
        <template v-slot:slotButton>

        </template>

    </form-tab>
</template>

<script>
    import AlertWindow    from "@/components/base/AlertWindow.vue";
    import FormTab        from "@/components/base/FormTab.vue";
    import Lista          from "@/components/base/Lista";

    export default {
        components: {
            'validate-window': AlertWindow,
            'form-tab': FormTab,
            'my-list': Lista

        },
        name: "form-incasez",
        created() {
            this.REF_FORM = 'refFormIncasez';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            message: []
            };
            this.cfgtime = {
                CFG_INVOICE_LIST : {
                    ref: 'refDetailList',
                    header: [
	                    this.$constList.getHeader(1, 'Tip factura',     70, 'tip_factura',       this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(2, 'Nr. factura',     70, 'nr_factura',        this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(3, 'Data factura',    70, 'data_f',            this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(4, 'Client',          70, 'client_name',       this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(5, 'Org.',            70, 'client_tip_firma',  this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(6, 'CUI',             70, 'client_cod_fiscal', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
	                    this.$constList.getHeader(7, 'Suma factura',    70, 'total_factura',     this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
	                    this.$constList.getHeader(8, 'Suma incasata',   70, 'total_incasat',     this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
	                    this.$constList.getHeader(9, '... de incasat',  70, 'rest_de_incasat',   this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT)

                        // this.$constList.getHeader(5, 'Action', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],
                    recordActionButon: [
                        // this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        //this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
                    ],
                    cfg: {  urlData: 'listaUnpaidInvoices', loadOnCreate: true,
                            filedNameForCheckBox: 'activ', emitListRowSelection: 'emitListRowSelection',
                            heightList: 300
                    }
                },
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
        },
        methods: {
        },
        data () {
            return {
            }
        }
    }

</script>

<style scoped></style>



