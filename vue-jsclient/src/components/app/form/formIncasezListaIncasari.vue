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
                                <my-button  :ref=this.cfgtime.REF_BUTTON_REFRESH @click="this.clickRefresIncomingList" :heightButton=22 :buttonType=2 title="refresh lista" :style="this.cfgtime.ICON_REFRESH.colorStyle">
                                    <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_REFRESH) size="1x" />
                                </my-button>
                                &nbsp;&nbsp;
                                <my-button  :ref=this.cfgtime.REF_BUTTON_REFRESH @click="this.clickExportExcel" :heightButton=22 :buttonType=2 title="export excel incasari" :style="this.cfgtime.ICON_EXCEL.colorStyle">
                                    <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_EXCEL) size="1x" />
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
                            <label>Numar incasari:</label></td>
                        <td class="control">
                            {{this.dataRezume.nr_records}}
                        </td>
                        <td class="label-left bold">
                            <label>&nbsp;&nbsp;&nbsp;Suma incasata:</label></td>
                        <td class="control">
                            {{this.dataRezume.total_incasari}}
                        </td>
                    </tr>
                </table>
            </div>
            <my-list
                :ref = this.cfgtime.CFG_INVOICE_LIST.ref
                :pConfig = this.cfgtime.CFG_INVOICE_LIST
                @emitFinallyCustomResponse="emitListResumData"
                @emitStergIncasare = "emitStergIncasare"
                @emitPrintIncasare = "emitPrintIncasare"
            ></my-list>

        </template>

        <template v-slot:slotButton></template>
    </form-tab>

</template>

<script>
    import AlertWindow      from "@/components/base/AlertWindow.vue";
    import FormTab          from "@/components/base/FormTab.vue";
    import Lista            from "@/components/base/Lista";
    import CheckBox         from "@/components/base/CheckBox.vue";
    import InputDateTime    from "@/components/base/InputDateTime.vue";
    import RadioButton      from "@/components/base/RadioButton.vue";
    import Button           from "@/components/base/Button";
    import DropDownSearch from "@/components/base/DropDownSearch.vue";



    export default {
        components: {
            'validate-window': AlertWindow,
            'form-tab': FormTab,
            'my-list': Lista,
	        'check-box': CheckBox,
	        'my-datetime': InputDateTime,
            'my-dropdown-search': DropDownSearch,
            'my-radio-button': RadioButton,
            'my-button': Button
        },
        name: "form-incasez",
        created() {
            this.REF_FORM = 'refFormListaIncasari';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            message: [],
                paramInvoiceList: {'dataIn': null, 'dataSf': null, idPartner: 0},
                postDeleteItem: { idPk: null, field: {}, sqlAction: null},
                post: { idPk: null}
            };
            this.cfgtime = {
                REF_BUTTON_REFRESH: 'refButtonRefresh',
                ICON_REFRESH: this.$constComponent.ICON_REFRESH("green"),
                ICON_EXCEL: this.$constComponent.ICON_EXCEL("blue"),
	            DATA_IN: this.cfgDataIn(),
                DATA_SF: this.cfgDataSf(),
                PARTNER_LIST: this.cfgDropDownPartner(),
                URL_DELETE_INCOMING_ITEM: this.$url.getUrl('deleteIncomingDoc'),
                URL_RECEIPT_PRINT: this.$url.getUrl('receiptPrint'),
                URL_REPORT_INCOMING_EMITTED: this.$url.getUrl('reportIncasari'),
                CFG_INVOICE_LIST : {
                    ref: 'refDetailList',
                    header: [
	                    this.$constList.getHeader(1, 'Tip doc.',        140, 'tip_document',    this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
                        this.$constList.getHeader(2, 'Tip incasare',    100, 'tip_incasare',    this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER ),
	                    this.$constList.getHeader(3, 'Data chitanta',    90, 'data_i',          this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER ),
	                    this.$constList.getHeader(4, 'Nr. chitanta',    130, 'numar_chitanta',  this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER  ),
	                    this.$constList.getHeader(5, 'Suma incasata',   120, 'suma',            this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_RIGHT),
	                    this.$constList.getHeader(6, 'Client',          450, 'nume_client',     this.$constList.HEADER.CAPTION_TYPE_FIELD),
	                    this.$constList.getHeader(7, 'Nr factura',     120, 'numar_factura',    this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER),
                        this.$constList.getHeader(5, 'Action', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],
                    recordActionButon: [
                        this.$constList.getActionButton(10, 'sterg incasare', 'emitStergIncasare', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null),
                        this.$constList.getActionButton(11, 'printez incasare', 'emitPrintIncasare', this.$constGrid.ICON_PRINT, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        // this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
                    ],
                    cfg: {  urlData: 'incomingList', loadOnCreate: false,
                            filedNameForCheckBox: 'activ',
                            headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
                            emitListRowSelection: 'emitListRowSelection',
                            heightList: 700
                    }
                },
            };
        },
        emits: [],
        mounted () {
            this.privateSetListInvoiceParameter();
            // this.refreshInvoiceList();
        },
        methods: {
            clickExportExcel: function (){
                this.privateSetListInvoiceParameter();

                this.$refs[this.REF_FORM].showModal(true);

                this.axios
                    .post(this.cfgtime.URL_REPORT_INCOMING_EMITTED, this.runtime.paramInvoiceList)
                    .then(response => {
                        if (response.data.succes){
                            this.$print.downloadXLSX(response.data.custom.fileName, response.data.custom.xls);
                        }
                        else {
                        }
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.$refs[this.REF_FORM].showModal(false);
                    });

            },
            emitPrintIncasare: function (button){
                let tr = button.closest('tr');
                this.runtime.post.idPk = tr.getAttribute('idPk');

                this.$refs[this.REF_FORM].showModal(true);

                this.axios.post(this.cfgtime.URL_RECEIPT_PRINT, this.runtime.post)
                    .then((response) => {


                        /*
                        const linkSource = `data:application/pdf;base64,${response.data.pdf}`;
                        const downloadLink = document.createElement("a");

                        downloadLink.href = linkSource;
                        downloadLink.download = response.data.fileName;

                        window.open(downloadLink, '_blank');
                        // downloadLink.click();
                    */


                        //this.$print.showDocument(response.data.pdf, 'data:application/pdf');
                        this.$print.downloadPdf(response.data.fileName, response.data.pdf);


                    }).finally(() => {
                    this.$refs[this.REF_FORM].showModal(false);
                });


            },
            refreshInvoiceList: function(){
                this.privateSetListInvoiceParameter();
                this.$refs[this.cfgtime.CFG_INVOICE_LIST.ref].showList(this.runtime.paramInvoiceList);
            },
            clickRefresIncomingList: function(){
                this.refreshInvoiceList();
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
            serverDeleteItem: function (){
                if(!this.runtime.sendDataToServer) {
                    this.$refs.refYesNo.setCaption("Sterg");
                    this.$refs.refYesNo.setMessage("Sterg incasarea ? <br> Numarul documentului va fi refolosit la urmatoarea incasare.");
                    this.$refs.refYesNo.show();
                }

                if(this.runtime.sendDataToServer) {
                    this.runtime.sendDataToServer = false;

                    this.$refs[this.REF_FORM].showModal(true);
                    this.axios
                        .post(this.cfgtime.URL_DELETE_INCOMING_ITEM, this.runtime.postDeleteItem)
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
            emitStergIncasare: function (button){
                let tr = button.closest('tr');
                this.runtime.postDeleteItem.idPk = tr.getAttribute('idPk');
                this.serverDeleteItem();
            },
            emitListResumData: function (dataResume){
                this.dataRezume.nr_records = dataResume.nr_records;
                this.dataRezume.total_incasari = dataResume.total_incasari;
            },
	        emitYesNo: function(yes){
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this.serverDeleteItem();
                }else{
                    this.runtime.sendDataToServer = false;
                }

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
                dataRezume: {nr_records: 0, total_incasari: 0}
            }
        }
    }

</script>

<style scoped></style>



