<template>
    <section class="content">
      <div class="container-fluid">
          <div class="row">
  
            <div class="col-12">
          
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">List of Purchase Order</h3>
  
                  <div class="card-tools">
                    
                    <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                        <i class="fa fa-plus-square"></i>
                        Add New
                    </button>

                    <button type="button" class="btn btn-sm btn-primary" @click="searchModal">
                        <i class="fa fa-search"></i>
                        Search
                    </button>
                  </div>
  
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Employee Name</th>
                        <th>Work Base</th>
                        <th>PO Number</th>
                        <th>PO / SO Agreement Start</th>
                        <th>PO / SO Agreement End</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(purchaseorder,index) in purchaseorders.data" :key="purchaseorder.id"> 
                        <td>{{index + 1}}</td>  
                        <td>{{purchaseorder.employee.name}}</td>
                        <td>{{purchaseorder.workbase.name}}</td>
                        <td>{{purchaseorder.PO_number}}</td>
                        <td>{{purchaseorder.PO_start}}</td>
                        <td>{{purchaseorder.PO_end}}</td>
                        <td>
                          <a href="#" @click="editModal(purchaseorder)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a href="#" @click="showModal(purchaseorder)">
                              <i class="fa fa-eye"></i>
                          </a>
                          /
                          <a href="#" @click="deletePurchaseOrder(purchaseorder.id)">
                              <i class="fa fa-trash red"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="purchaseorders" @pagination-change-page="getResults"></pagination>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
  
          <!-- Modal -->
          <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode">Create New Purchase Order</h5>
                        <h5 class="modal-title" v-show="editmode">Edit Purchase Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <form @submit.prevent="editmode ? updatePurchaseOrder() : createPurchaseOrder()">
                        <div class="modal-body">
                          <div class="form-group">
                                <label>PO No</label>
                                <input v-model="form.PO_number" type="text" name="PO_number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('PO_number') }">
                                <has-error :form="form" field="PO_number"></has-error>
                            </div>
                            <div class="form-group">
                            <label>Employee Name</label>
                            <select class="form-control" v-model="form.employee_id">
                              <option 
                                  v-for="(cat,index) in employees" :key="index"
                                  :value="cat.id"
                                  :selected="index == form.employee_id">{{ cat.name }}</option>
                            </select>
                            <has-error :form="form" field="employee_id"></has-error>
                            </div>
                            <div class="form-group">
                            <label>Work Base</label>
                            <select class="form-control" v-model="form.workbase_id">
                              <option 
                                  v-for="(cat,index) in workBases" :key="index"
                                  :value="index"
                                  :selected="index == form.workbase_id">{{ cat }}</option>
                            </select>
                            <has-error :form="form" field="workbase_id"></has-error>
                            </div>
                            <div class="form-group">
                                <label>PO Agreement Start</label>
                                <input v-model="form.PO_start" type="date" name="PO_start"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('PO_start') }">
                                <has-error :form="form" field="PO_start"></has-error>
                            </div>
                            <div class="form-group">
                                <label>PO Agreement End</label>
                                <input v-model="form.PO_end" type="date" name="PO_end"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('PO_end') }">
                                <has-error :form="form" field="PO_end"></has-error>
                            </div>
                            <div class="form-group">
                                <label>PO Normal Rate</label>
                                <input v-model="form.PO_normal_rate" type="text" name="PO_normal_rate"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('PO_normal_rate') }">
                                <has-error :form="form" field="PO_normal_rate"></has-error>
                            </div>
                            <div class="form-group">
                                <label>PO Over Time Rate</label>
                                <input v-model="form.PO_OT_rate" type="text" name="PO_OT_rate"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('PO_OT_rate') }">
                                <has-error :form="form" field="PO_OT_rate"></has-error>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                        </div> 
                      </form>
                  </div>
              </div>
            </div>
            <!-- End Modal --> 

            <!-- Modal Search -->
          <div class="modal fade" id="searchEmployee" tabindex="-1" role="dialog" aria-labelledby="searchEmployee" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode">Create New Purchase Order</h5>
                        <h5 class="modal-title" v-show="editmode">Edit Purchase Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <form @submit.prevent="searchPurchaseOrder()">
                        <div class="modal-body">
                            <div class="form-group">
                            <label>Employee Name</label>
                            <select class="form-control" v-model="form.employee_id">
                              <option 
                                  v-for="(cat,index) in employees" :key="cat.id"
                                  :value="cat.id"
                                  :selected="index == form.employee_id">{{ cat.name }}</option>
                            </select>
                            <has-error :form="form" field="employee_id"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div> 
                      </form>
                  </div>
              </div>
            </div>
            <!-- End Modal -->
      </div>
    </section>
  </template>
  
  <script>
      import VueTagsInput from '@johmun/vue-tags-input';
  import index from '../../../../../Laravel-8-multi-auth-based-on-Roles-with-examples/public/plugins/popper/popper-utils';
  
      export default {
        components: {
            VueTagsInput,
          },
          data () {
              return {
                  editmode: false,
                  // modalShow: false,
                  purchaseorders : {},
                  form: new Form({
                    id:'',
                    employee_id : '',
                    workbase_id: '',
                    PO_number: '',
                    PO_start: '',
                    PO_end: '',
                    PO_normal_rate: '',
                    PO_OT_rate: '',
                  }),
                  employees: [],
                  workBases: [],

                
                  // tag:  '',
                  autocompleteItems: [],
              }
          },
          methods: {
  
            getResults(page = 1) {
  
                this.$Progress.start();
                
                axios.get('api/purchaseorder?page=' + page).then(({ data }) => (this.purchaseorders = data.data));
  
                this.$Progress.finish();
            },
            loadPurchaseOrders(){
  
              // if(this.$gate.isAdmin()){
                axios.get("api/purchaseorder").then(({ data }) => (this.purchaseorders = data.data));              
              // }
            },
            loadEmployees(){
                axios.get("/api/employee/list").then(({ data }) => (this.employees = data.data));
            },
            loadWorkBases(){
                axios.get("/api/workbase/list").then(({ data }) => (this.workBases = data.data));
            },
           
            editModal(purchaseorder){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(purchaseorder);
            },
            showModal(purchaseorder){
                this.editmode = true;
                this.form.reset();
                $('#showdata').modal('show');
                this.form.fill(purchaseorder);
                // this.loadEmployees();
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            searchModal(){
                this.editmode = false;
                this.form.reset();
                $('#searchEmployee').modal('show');
            },
            searchPurchaseOrder(){
                this.$Progress.start();
                this.form.post('api/purchaseorder/search')
                .then((data)=>{
                  if(data.data.success){
                    $('#searchEmployee').modal('hide');
  
                    Toast.fire({
                          icon: 'success',
                          title: data.data.message
                      });
                    this.$Progress.finish();
                    this.purchaseorders = data.data.data
  
                  } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                    this.$Progress.failed();
                  }
                })
                .catch(()=>{
  
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
            },
            createPurchaseOrder(){
                this.$Progress.start();
                this.form.post('api/purchaseorder')
                .then((data)=>{
                  if(data.data.success){
                    $('#addNew').modal('hide');
  
                    Toast.fire({
                          icon: 'success',
                          title: data.data.message
                      });
                    this.$Progress.finish();
                    this.loadPurchaseOrders();
  
                  } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
  
                    this.$Progress.failed();
                  }
                })
                .catch(()=>{
  
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
            },
            updatePurchaseOrder(){
              console.log("form",this.form)
                this.$Progress.start();
                console.log("id",this.form.id)
                this.form.put('api/purchaseorder/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');
  
                    this.loadPurchaseOrders();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
  
            },
            deletePurchaseOrder(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
  
                        // Send request to the server
                          if (result.value) {
                                this.form.delete('api/purchaseorder/'+id).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.loadPurchaseOrders();
                                }).catch((data)=> {
                                    Swal.fire("Failed!", data.message, "warning");
                                });
                          }
                    })
            },
  
          },
          mounted() {
              
          },
          created() {
              this.$Progress.start();
  
              this.loadPurchaseOrders();
              this.loadEmployees();
              this.loadWorkBases();
              // this.loadTags();
  
              // this.$Progress.finish();
          },
          filters: {
              truncate: function (text, length, suffix) {
                  return text.substring(0, length) + suffix;
              },
          },
          computed: {
            filteredItems() {
              return this.autocompleteItems.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
              });
            },
          },
      }
  </script>