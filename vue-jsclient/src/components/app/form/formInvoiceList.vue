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
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButton"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
        </template>
        <template v-slot:slotContent>
            <table class="ff-form-table">
                <tr>
                    <td class="label-left bold" colspan="1">
                        <label :for=this.cfgtime.DATA_IN.id>{{this.cfgtime.DATA_IN.caption}}</label>
                        &nbsp;
                        <my-datetime
                            :ref = this.cfgtime.DATA_IN.ref
                            :pConfig = this.cfgtime.DATA_IN
                        ></my-datetime>
                        -
                        <my-datetime
                            :ref = this.cfgtime.DATA_SF.ref
                            :pConfig = this.cfgtime.DATA_SF
                        ></my-datetime>
                    </td>

                    <td class="control">
                        <my-dropdown-search :ref = this.cfgtime.PARTNER_LIST.ref
                                            :pConfig = this.cfgtime.PARTNER_LIST
                        ></my-dropdown-search>
                    </td>

                    <td class="control">
                        <div class="prime-button last-button">
                            &nbsp;
                            <my-button  :ref=this.cfgtime.REF_BUTTON_REFRESH @click="this.clickRefresInvoiceList" :heightButton=22 :buttonType=2 title="refresh lista" :style="this.cfgtime.ICON_REFRESH.colorStyle">
                                <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_REFRESH) size="1x" />
                            </my-button>
                        </div>
                    </td>
                </tr>
            </table>

            <br>

            <div class="form-rezumat-left">
                <table class="ff-form-table">
                    <tr>
                        <td class="label-left bold">
                            <label>Facturi emise:</label></td>
                        <td class="control">
                            {{this.dataRezume.record_count}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;Total facturat:</label></td>
                        <td class="control">
                            {{this.dataRezume.total}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;Suma incasata:</label></td>
                        <td class="control">
                            {{this.dataRezume.incasat}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;Ramas de incasat:</label></td>
                        <td class="control">
                            {{this.dataRezume.ramas_de_incasat}}
                        </td>
                    </tr>
                </table>
            </div>

            <my-list
                :ref = this.cfgtime.CFG_INVOICE_LIST.ref
                :pConfig = this.cfgtime.CFG_INVOICE_LIST
                @emitFinallyCustomResponse="emitListResumData"
                @emitStergArticol = "emitStergArticol"
                @emitPrintArticol = "emitPrintArticol"
            ></my-list>

        </template>
        <template v-slot:slotButton>
        </template>
    </form-tab>
</template>

<script>
    import AlertWindow      from "@/components/base/AlertWindow.vue";
    import FormTab          from "@/components/base/FormTab.vue";
    import InputDateTime    from "@/components/base/InputDateTime.vue";
    import DropDownSearch from "@/components/base/DropDownSearch.vue";
    import Button           from "@/components/base/Button";
    import Lista            from "@/components/base/Lista";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'my-datetime': InputDateTime,
            'my-dropdown-search': DropDownSearch,
            'my-button': Button,
            'my-list': Lista
        },
        name: "form-partener",
        created() {
            this.REF_FORM = 'refFormInvoiceList';
            this.cfgtime = {
                ICON_REFRESH: this.$constComponent.ICON_REFRESH("green"),
                DATA_IN: this.cfgDataIn(),
                DATA_SF: this.cfgDataSf(),
                PARTNER_LIST: this.cfgDropDownPartner(),
                URL_DELETE_INVOICE: this.$url.getUrl('deleteInvoice'),
                URL_INVOICE_PRINT: this.$url.getUrl('invoicePrint'),
                CFG_INVOICE_LIST : {
                    ref: 'refInvoiceList',
                    header: [
                        this.$constList.getHeader(1, 'Tip factura',      110, 'tip_factura'         ,this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(2, 'Nr. factura',      110, 'nr_factura'          ,this.$constList.HEADER.CAPTION_TYPE_FIELD , this.$constComponent.ALIGN_TEXT_CENTER ),
                        this.$constList.getHeader(3, 'Data factura',      90, 'data_f_view'         ,this.$constList.HEADER.CAPTION_TYPE_FIELD , this.$constComponent.ALIGN_TEXT_CENTER ),
                        this.$constList.getHeader(4, 'Client',           490, 'client_name'         ,this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(5, 'Org.',              50, 'client_tip_firma'    ,this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
                        this.$constList.getHeader(6, 'CUI',               70, 'client_cod_fiscal'   ,this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                        this.$constList.getHeader(7, 'Suma factura',      90, 'total_factura'       ,this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
                        this.$constList.getHeader(8, 'Suma incasata',     90, 'total_incasat'       ,this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
                        this.$constList.getHeader(9, '... de incasat',    90, 'rest_de_incasat'     ,this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
                        this.$constList.getHeader(10, 'Action',          100, 'null'                ,this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],
                    recordActionButon: [
                        this.$constList.getActionButton(21, 'sterg factura', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null),
                        this.$constList.getActionButton(20, 'printez factura', 'emitPrintArticol', this.$constGrid.ICON_PRINT, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        // this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
                    ],
                    cfg: {  urlData: 'invoicesList', loadOnCreate: false,
                        filedNameForCheckBox: 'activ',
                        headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
                        emitListRowSelection: 'emitListRowSelection',
                        heightList: 610
                    }
                }
            },
            this.runtime = {
                sendDataToServer: false,
                yesNoMethod: null,
                paramInvoiceList: {'dataIn': null, 'dataSf': null, idPartner: 0},
                post: { idPk: null, field: {}, sqlAction: null}
            }
        },
        // emits: ['emitModel'],
        mounted () {
        },
        methods: {
            clickRefresInvoiceList: function (){
                this.refreshInvoiceList();
            },
            serverDeleteInvoice: function (){
                this.runtime.yesNoMethod = 'serverDeleteInvoice';

                if(!this.runtime.sendDataToServer) {
                    this.$refs.refYesNo.setCaption("Sterg factura");
                    this.$refs.refYesNo.setMessage("Sterg factura ? <br> Numarul documentului va fi refolosit la urmatoarea factura.");
                    this.$refs.refYesNo.show();
                }

                if(this.runtime.sendDataToServer) {
                    this.runtime.sendDataToServer = false;

                    this.$refs[this.REF_FORM].showModal(true);
                    this.axios
                        .post(this.cfgtime.URL_DELETE_INVOICE, this.runtime.post)
                        .then(response => {
                            if (response.data.succes){
                            }
                            else {
                                this.$refs.validateWindowRef.setCaption("Fail...");
                                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                this.$refs.validateWindowRef.show();
                            }

                        })
                        .catch(error => console.log(error))
                        .finally(() => {
                            this.refreshInvoiceList();
                            this.$refs[this.REF_FORM].showModal(false);
                        });
                }
            },
            refreshInvoiceList: function(){
                this.privateSetListInvoiceParameter();
                this.$refs[this.cfgtime.CFG_INVOICE_LIST.ref].showList(this.runtime.paramInvoiceList);
            },
            privateSetListInvoiceParameter: function (){
                this.runtime.paramInvoiceList.dataIn = this.$refs[this.cfgtime.DATA_IN.ref].getValue();
                this.runtime.paramInvoiceList.dataSf = this.$refs[this.cfgtime.DATA_SF.ref].getValue()

                let partnerParam = this.$refs[this.cfgtime.PARTNER_LIST.ref].getValue();
                if(this.$check.isUndef(partnerParam)){
                    this.runtime.paramInvoiceList.idPartner = 0;
                }else{
                    this.runtime.paramInvoiceList.idPartner = partnerParam.id;
                }

            },
            emitPrintArticol: function (button){
                let tr = button.closest('tr');
                this.runtime.post.idPk = tr.getAttribute('idPk');

                this.$refs[this.REF_FORM].showModal(true);

                this.axios.post(this.cfgtime.URL_INVOICE_PRINT, this.runtime.post)
                    .then((response) => {
                        const linkSource = `data:application/pdf;base64,${response.data.pdf}`;
                        const downloadLink = document.createElement("a");

                        downloadLink.href = linkSource;
                        downloadLink.download = response.data.fileName;
                        downloadLink.click();

                }).finally(() => {
                    this.$refs[this.REF_FORM].showModal(false);
                });


                /*
                this.axios
                    .post(this.cfgtime.URL_INVOICE_PRINT, this.runtime.post)
                    .then(response => {
                        if (response.data.succes){
                        }
                        else {
                            this.$refs.validateWindowRef.setCaption("Fail...");
                            this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                            this.$refs.validateWindowRef.show();
                        }

                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.$refs[this.REF_FORM].showModal(false);
                    });
                 */

            },
            emitStergArticol: function (button){
                let tr = button.closest('tr');
                this.runtime.post.idPk = tr.getAttribute('idPk');
                this.serverDeleteInvoice();
            },
            emitListResumData: function(data){
                this.dataRezume.total = data.total;
                this.dataRezume.incasat = data.sumaIncasata;
                this.dataRezume.ramas_de_incasat = data.ramasDeIncasat;
                this.dataRezume.record_count = data.records_count;

            },
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this[this.runtime.yesNoMethod].apply();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
            setPost: function (component, value){
                this.runtime.post['field'][component.name] = value;
            },
            cfgDropDownPartner: function(){
                let cfg = this.$app.cfgSelectSearch('nomPartner', this.$url.getUrl('listPartener'), 450);
                cfg.setValidateFunction(this.validatePartner);
                cfg.setCaption("Partener");
                cfg.setMandatory(true);
                return cfg;
            },
            cfgDataIn: function(){
                let cfg = this.$app.cfgInputDateTimeField("invoiceDateIn", 11, 80);
                cfg.setValidateFunction(this.validateDocumentDate);
                cfg.setCaption("Interval");
                cfg.setMandatory(true);
                cfg.setShowDefault(this.$constBussines.DATE_FIRSTDAY);
                return cfg;
            },
            cfgDataSf: function(){
                let cfg = this.$app.cfgInputDateTimeField("invoiceDateSf", 11, 80);
                cfg.setValidateFunction(this.validateDocumentDate);
                cfg.setCaption("Interval");
                cfg.setMandatory(true);
                cfg.setShowDefault(this.$constBussines.DATE_CURRENT);
                return cfg;
            }
        },
        data () {
            return {
                dataRezume: {record_count: 0, total: 0.00, incasat: 0.00, ramas_de_incasat: 0.00}
            }
        }
    }

</script>

<style scoped></style>
