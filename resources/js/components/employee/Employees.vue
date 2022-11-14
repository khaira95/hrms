<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Employee</h3>

                <div class="card-tools">
                  
                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Employee No</th>
                      <th>Name</th>
                      <th>Contact Number</th>
                      <th>Email</th>
                      <th>Designation</th>
                      <th>Current Workbase</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(employee,index) in employees.data" :key="employee.id"> 
                      <td>{{index + 1}}</td>  
                      <td>{{employee.employeeno}}</td>
                      <td>{{employee.name}}</td>
                      <td>{{employee.contactno | truncate(30, '...')}}</td>
                      <td>{{employee.email}}</td>
                      <td>{{employee.designation}}</td>
                      <td>{{employee.workbase.name}}</td>
                      <td>
                        <a href="#" @click="editModal(employee)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="showModal(employee)">
                            <i class="fa fa-eye"></i>
                        </a>
                        /
                        <a href="#" @click="deleteEmployee(employee.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="employees" @pagination-change-page="getResults"></pagination>
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
                      <h5 class="modal-title" v-show="!editmode">Create New Employee</h5>
                      <h5 class="modal-title" v-show="editmode">Edit Employee</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div> 
                  <form @submit.prevent="editmode ? updateEmployee() : createEmployee()">
                      <div class="modal-body">
                        <div class="form-group">
                              <label>Employee No</label>
                              <input v-model="form.employeeno" type="text" name="employeeno"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('employeeno') }">
                              <has-error :form="form" field="employeeno"></has-error>
                          </div>
                          <div class="form-group">
                              <label>Name</label>
                              <input v-model="form.name" type="text" name="name"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                              <has-error :form="form" field="name"></has-error>
                          </div>
                          <div class="form-group">
                              <label>IC Number</label>
                              <input v-model="form.icno" type="text" name="icno"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('icno') }">
                              <has-error :form="form" field="icno"></has-error>
                          </div>
                          <div class="form-group">
                              <label>Email</label>
                              <input v-model="form.email" type="email" name="email"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                              <has-error :form="form" field="email"></has-error>
                          </div>
                          <div class="form-group">
                              <label>Address</label>
                              <input v-model="form.address" type="text" name="address"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                              <has-error :form="form" field="address"></has-error>
                          </div>
                          <div class="form-group">
                              <label>Contact Number</label>
                              <input v-model="form.contactno" type="number" name="contactno"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('contactno') }">
                              <has-error :form="form" field="contactno"></has-error>
                          </div>
                          <div class="form-group">
                              <label>Education Level</label>
                              <input v-model="form.educationlevel" type="text" name="educationlevel"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('educationlevel') }">
                              <has-error :form="form" field="educationlevel"></has-error>
                          </div>
                          <div class="form-group">
                              <label>Field Study</label>
                              <input v-model="form.fieldstudy" type="text" name="fieldstudy"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('fieldstudy') }">
                              <has-error :form="form" field="fieldstudy"></has-error>
                          </div>
                          <div class="form-group">
                              <label>Designation</label>
                              <input v-model="form.designation" type="text" name="designation"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('designation') }">
                              <has-error :form="form" field="designation"></has-error>
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
                              <label>CV Number</label>
                              <input v-model="form.cvno" type="text" name="cvno"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('cvno') }">
                              <has-error :form="form" field="cvno"></has-error>
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
          
        <!-- Modal -->
        <div class="modal fade" id="showdata" tabindex="-1" role="dialog" aria-labelledby="showdata" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" v-show="editmode">Employee Detail</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div> 
                  <form >
                      <div class="modal-body">
                        <div class="form-group">
                              <label>Employee No</label>
                              <input v-model="form.employeeno" disabled name="employeeno" class="form-control" >
                          </div>
                          <div class="form-group">
                              <label>Name</label>
                              <input v-model="form.name" readonly="text" name="name" class="form-control" >
                          </div>
                          <div class="form-group">
                              <label>IC Number</label>
                              <input v-model="form.icno" readonly="text" name="icno" class="form-control">
                          </div>
                          <div class="form-group">
                              <label>Email</label>
                              <input v-model="form.email" readonly="email" name="email" class="form-control">
                          </div>
                          <div class="form-group">
                              <label>Address</label>
                              <input v-model="form.address" readonly="text" name="address" class="form-control">
                          </div>
                          <div class="form-group">
                              <label>Contact Number</label>
                              <input v-model="form.contactno" readonly="number" name="contactno" class="form-control" >
                          </div>
                          <div class="form-group">
                              <label>Education Level</label>
                              <input v-model="form.educationlevel" readonly="text" name="educationlevel" class="form-control">
                          </div>
                          <div class="form-group">
                              <label>Field Study</label>
                              <input v-model="form.fieldstudy" readonly="text" name="fieldstudy" class="form-control" >
                          </div>
                          <div class="form-group">
                              <label>Designation</label>
                              <input v-model="form.designation" readonly="text" name="designation" class="form-control" >
                          </div>
                          <div class="form-group">
                              <label>Work Base</label>
                              <input v-model="form.workbase.name" readonly="text" name="workbase" class="form-control">
                          </div>
                          <div class="form-group">
                              <label>CV Number</label>
                              <input v-model="form.cvno" readonly="text" name="cvno" class="form-control">
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                employees : {},
                form: new Form({
                  id:'',
                  employeeno : '',
                  name: '',
                  icno: '',
                  email:  '',
                  address: '',
                  contactno: '',
                  educationlevel: '',
                  fieldstudy: '',
                  designation: '',
                  workbase_id: '',
                  workbase:{},
                  cvno: '',
                }),
                workBases: [],
              
                // tag:  '',
                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();
              
              axios.get('api/employee?page=' + page).then(({ data }) => (this.employees = data.data));

              this.$Progress.finish();
          },
          loadEmployees(){

            // if(this.$gate.isAdmin()){
              axios.get("api/employee").then(({ data }) => (this.employees = data.data));              
            // }
          },
          loadWorkBases(){
              axios.get("/api/workbase/list").then(({ data }) => (this.workBases = data.data));
          },
          // loadTags(){
          //     axios.get("/api/tag/list").then(response => {
          //         this.autocompleteItems = response.data.data.map(a => {
          //             return { text: a.name, id: a.id };
          //         });
          //     }).catch(() => console.warn('Oh. Something went wrong'));
          // },
          editModal(employee){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(employee);
          },
          showModal(employee){
            console.log("employee",employee)
              this.editmode = true;
              this.form.reset();
              $('#showdata').modal('show');
              this.form.fill(employee);
              // this.loadEmployees();
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createEmployee(){
              this.$Progress.start();
              this.form.post('api/employee')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadEmployees();

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
          updateEmployee(){
            console.log("form",this.form)
              this.$Progress.start();
              console.log("id",this.form.id)
              this.form.put('api/employee/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadEmployees();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteEmployee(id){
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
                              this.form.delete('api/employee/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadEmployees();
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