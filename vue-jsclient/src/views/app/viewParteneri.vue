<template>
    <div class="ff-workbench" ref="refWorkBench">
        <tab-parteneri ref="refTab"
            :pConfig=this.tabConfig
            @emitClickTab="emitClickTab"
        >
            <template v-slot:tabs>
                <div class="tab" :id="this.$constTab.getIdTab('1p')">
                    <div class="up-line"></div>
                    <my-grid ref="gridParteneri"
                             :pConfig=this.gridConfig
                              @emitSelectDataOnGrid = "emitSelectDataOnGrid"
                    ></my-grid>
                </div>
                <div class="tab" :id="this.$constTab.getIdTab('3p')">
                    <div class="up-line"></div>
                    <my-grid :ref=this.REF_GRID_INVOICES
                             :pConfig=this.gridConfigPartnerInvoices
                             @emitSelectDataGridInvoices = "emitSelectDataGridInvoices"
                    ></my-grid>

                </div>
                <div class="tab" :id="this.$constTab.getIdTab('2p')">
                    <div class="up-line"></div>

                    <form-partener :ref=this.REF_PARTENER_EDIT
                        @emitNewRecord = "emitNewRecord"
                    ></form-partener>
                </div>
            </template>
        </tab-parteneri>

    </div>
</template>

<script>
    import Tab from "@/components/base/Tab";
    import Gridul from '@/components/base/Gridul';
    import formPartener from '@/components/app/form/formPartener';
    import Button from "@/components/base/Button";

    export default {
		components: {
            'tab-parteneri': Tab,
            'my-grid': Gridul,
            'form-partener': formPartener,
            'my-button': Button
        },
		name: "view-parteneri",
		created() {
		    this.REF_PARTENER_EDIT = 'refPartenerEdit',
            this.REF_GRID_INVOICES = 'refGridParteneriInvoices',
            this.TAB_EDIT = {id: '2p', urlGetDate: this.$url.getUrl('partenerGetData')},
		    this.TAB_PARTENERI = {id: '1p'},
            this.TAB_FACTURI = {id: '3p', isLoading: false},
            this.ICON_ADD_PARTENER =  this.$constComponent.ICON_ADD_PERSON("blue");
            this.tabConfig = {
                header: [
                    this.$constTab.getHeader('1p','Parteneri'),
                    this.$constTab.getHeader('3p','Facturi'),
                    this.$constTab.getHeader('2p','Editare date partener'),
                ],
                defaultTabId: '1p',
                tabsWidth: '1040px'
            },
            this.gridConfig = {
                    header: [
                        this.$constGrid.HEADER.getHeader(1,'Nume',450,'cNume', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, true, true, null, null),
                        this.$constGrid.HEADER.getHeader(2,'Organizare',180,'cTipAbrev', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, true, true, 't_tip_organizare_juridica.cTipAbrev', null),
                        this.$constGrid.HEADER.getHeader(3,'Registrul comertului',180,'regcom', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, false, true, null, null),
                        this.$constGrid.HEADER.getHeader(4,'RO',70,'ro_', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, false, false, true, null, null),
                        this.$constGrid.HEADER.getHeader(5,'Cui',100,'cui', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, false, false, true, null, null)
                    ],
                    actionButtonHeader: [
                        //this.$constGrid.getActionButton(7, 'Altceva din functie', 'altCeca', this.$constGrid.getIcon('fas','skull', '#adad00')),
                        // this.$constGrid.getActionButton(8, 'Print din functie', 'invoicePrint', this.$constGrid.ICON_PRINT)
                        //this.$constGrid.getActionButton(9, 'Edit din functie', 'deleteCeva', this.$constGrid.ICON_DELETE),
                        //this.$constGrid.getActionButton(10, 'Delete din functie', 'editCeva', this.$constGrid.ICON_EDIT)
                    ],
                    returnField: ['cNume'],             // return field and edit when selected row
                    cfg: {
                        width: 1100,
                        height: 500,
                        urlData: 'gridListParteneri',
                        loadOnCreate: true,
                    },
                    toolbar: {
                        show: true,
                        fieldShow: {
                            field: ['cNume'],        // shon on selection with mouse or keyboard
                            separator: " ",
                            includeIdPk: true
                        },
                        actionButton : [
                            // this.$constGrid.getActionButton( null,  'Print din functie', 'invoicePrintToolbar', this.$constGrid.ICON_PRINT),
                            // this.$constGrid.getActionButton( null,  'Edit din functie',   'deleteCevaToolbar', this.$constGrid.ICON_DELETE),
                            // this.$constGrid.getActionButton( null,  'Delete din functie', 'editCevaToolbar', this.$constGrid.ICON_EDIT)
                        ]
                    },
                    emitSelectData: 'emitSelectDataOnGrid',
                    paginate: {
                        nrButtonShow: 10,
                        recordsPerPage: 21
                    }
                },
                this.gridConfigPartnerInvoices = {
                    header: [
                        this.$constGrid.HEADER.getHeader(1,'Data factura',120,'data_f', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,          true,  true,  true, null, this.$constGrid.ALIGN_TEXT_CENTER),
                        this.$constGrid.HEADER.getHeader(2,'Nr. factura',150,'nr_f', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,             true,  false, true, null, null),
                        this.$constGrid.HEADER.getHeader(3,'TVA',30,'nProcTVA', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,                  false,  false, false, null, this.$constGrid.ALIGN_TEXT_CENTER),
                        this.$constGrid.HEADER.getHeader(4,'Total fara TVA',110,'nSumaFaraTva', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,  false, false, false, null, this.$constGrid.ALIGN_TEXT_RIGHT),
                        this.$constGrid.HEADER.getHeader(4,'Total TVA',110,'nSumaTVA', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,           false, false, false, null, this.$constGrid.ALIGN_TEXT_RIGHT),
                        this.$constGrid.HEADER.getHeader(4,'Total',120,'nTotal', this.$constGrid.HEADER.CAPTION_TYPE_FIELD,                 false, false, false, null, this.$constGrid.ALIGN_TEXT_RIGHT)
                        // this.$constGrid.HEADER.getHeader(6,'action',50,null, this.$constGrid.HEADER.CAPTION_TYPE_ACTION, false, false, false)
                    ],
                    actionButtonHeader: [
                        //this.$constGrid.getActionButton(7, 'Altceva din functie', 'altCeca', this.$constGrid.getIcon('fas','skull', '#adad00')),
                        // this.$constGrid.getActionButton(8, 'printeaza factura', 'invoicePrint', this.$constGrid.ICON_PRINT)
                        //this.$constGrid.getActionButton(9, 'Edit din functie', 'deleteCeva', this.$constGrid.ICON_DELETE),
                        //this.$constGrid.getActionButton(10, 'Delete din functie', 'editCeva', this.$constGrid.ICON_EDIT)
                    ],
                    returnField: ['data_f','nr_f'],             // return field and edit when selected row
                    cfg: {
                        width: 1100,
                        height: 500,
                        urlData: 'invocesListPartener',
                        loadOnCreate: false,
                    },
                    toolbar: {
                        show: true,
                        fieldShow: {
                            field: ['data_f','nr_f'],        // show on selection with mouse or keyboard
                            separator: " ",
                            includeIdPk: true
                        },
                        actionButton : [
                            // this.$constGrid.getActionButton( null,  'Print din functie', 'invoicePrintToolbar', this.$constGrid.ICON_PRINT),
                            // this.$constGrid.getActionButton( null,  'Edit din functie',   'deleteCevaToolbar', this.$constGrid.ICON_DELETE),
                            // this.$constGrid.getActionButton( null,  'Delete din functie', 'editCevaToolbar', this.$constGrid.ICON_EDIT)
                        ]
                    },
                    emitSelectData: 'emitSelectDataGridInvoices',
                    paginate: {
                        nrButtonShow: 10,
                        recordsPerPage: 19
                    }
                }
		},
        mounted () {
		    this.$refs.refTab.goToTab(this.tabConfig.defaultTabId);
            this.$refs.refTab.tabOnOff('2p','off');
        },
		methods: {
            emitNewRecord: function (newId){
                this.post.idPk = newId;
                this.changePartenerSelected = true; // resetez inregistrarea selectata
            },
		    emitClickTab: function (idTab) {
		        if(idTab == this.TAB_EDIT.id) {
                    this.$refs[this.REF_PARTENER_EDIT].getDataPartener(this.post.idPk);
                } else if(idTab == this.TAB_PARTENERI.id) {
                    if(this.changePartenerSelected){
                        this.changePartenerSelected = false;
                        this.$refs.gridParteneri.resetSelectionRow();
                    }
                }else if(idTab == this.TAB_FACTURI.id) {
		            if(!this.TAB_FACTURI.isLoading) {
                        this.TAB_FACTURI.isLoading = true;
                        this.$refs[this.REF_GRID_INVOICES].goToPage(null, '1');
                    }
                }
            },
            emitSelectDataGridInvoices: function () {
                 console.log('am selectat o factura');
            },
            emitSelectDataOnGrid: function (selectData) {

                console.log('am selectat un partener');

		        let onOff = 'on';
		        let title = null;
		        if(this.$check.isUndef(selectData)) {
                    onOff = 'off';
                    this.post.idPk = -1;
                } else {
                    this.post.idPk = selectData.idPk;
                    this.TAB_FACTURI.isLoading = false;
                }
                this.$refs.refTab.tabOnOff('2p', onOff);
		        // edit tab
            }
		},
		data () {
			return {
                post: { idPk: null },
                changePartenerSelected: false,
			    tabs: {
			        tab01: {},
                    tab02: {}
                }
            }
		}
	}

</script>

<style scoped></style>

