<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools">
                  
                  <button type="button" class="btn btn-block btn-primary" @click="newModal">New User
                  <i class="fas fa-user-plus fa-faw"></i></button>
                  
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Created At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>
                          <div v-for="role in user.roles" :key="role.id">
                            {{role.name | upText }}
                          </div>
                      </td>
                      <td>{{user.created_at | myDate }}</td>
                      <td>

                      <a href="#" @click="editModal(user)">
                        <i class="fa fa-edit"></i>
                      </a>
                       | 
                      <a href="#" @click="deleteUser(user.id)">
                        <i class="fa fa-trash" style="color:red"></i>
                      </a>

                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="createNewUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" v-show="!editmode" id="exampleModalLabel">Yangi User Qo'shish</h5>
                <h5 class="modal-title" v-show="editmode" id="exampleModalLabel">User Ma'lumotlarini O'zgartirish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form @submit.prevent="editmode ? updateUser() : createUser()">
              <div class="modal-body">

                <div class="form-group">
                  <input v-model="form.name" type="text" name="name" 
                    placeholder="Ism"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.email" type="email" name="email" 
                    placeholder="Email Adres"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                  <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
                  <select v-model="form.role" name="role" id="role" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                    <option value="">Select Role</option>
                    <option value="1">Admin</option>
                    <option value="2">User</option>

                  </select>
                  <has-error :form="form" field="role"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.password" type="password" name="password" 
                    placeholder="Password"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                  <has-error :form="form" field="password"></has-error>
                </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
              </div>

              </form>
            </div>
          </div>
        </div>
        <!-- End Of Modal -->
       
    </div>

    
</template>

<script>
    export default {

        data(){
            return{
                editmode: false,
                users: {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '', 
                    password: '',
                    role: '',
                })
            }

        },

        methods: {

            updateUser(){

              console.log("update starts")
              console.log(this.form.id)

              this.form.put('api/user/'+this.form.id)
              .then(function(response){

                $('#createNewUserModal').modal('hide')
                if(response.data.status === 'success')
                {
                  Reload.$emit('AfterCreate');

                  swal.fire(
                    'Updated!',
                    'User has been Updated.',
                    'success'
                  )

                }
                
                if(response.data.status === 'error')
                {
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                      footer: 'Xato: '+response.data.message
                    })
                }

              })
              .catch(()=>{

                // if failed
                swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Qandaydir Xatolik Boldi!',
                  footer: 'Xato: '
                })

              });

            },

            editModal(user){
              this.editmode = true
              this.form.reset()
              $('#createNewUserModal').modal('show')
              this.form.fill(user)
            },

            newModal(){
              this.editmode = false
              this.form.reset()
              $('#createNewUserModal').modal('show')
            },

            deleteUser(id){

              swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {

                if(result.value){

                  // send request to the server
                  this.form.delete('api/user/'+id).then(function(response){

                    if(response.data.status === 'success')
                    {
                      Reload.$emit('AfterCreate');

                      swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                      )

                    }
                    
                    if(response.data.status === 'error')
                    {
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Qandaydir Xatolik Boldi!',
                          footer: 'Xato: '+response.data.message
                        })
                    }

                  }).catch(()=>{

                      swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Qandaydir Xatolik Boldi!',
                        footer: 'Xato: '
                      })

                  });

                }

                
                
              })



            },
            
            loadUsers(){
                axios.get('api/user')
                .then(({ data }) => (this.users = data.users))
                .catch(function(error){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Qandaydir Xatolik Boldi!',
                        footer: 'Xato: '+response.data.message
                      })
                })
            },

            createUser(){
                
                this.form.post('api/user')
                .then(function(response){

                  if(response.data.status === 'success')
                  {
                    Reload.$emit('AfterCreate');
                    $('#createNewUserModal').modal('hide')

                    toast.fire({
                      icon: 'success',
                      title: 'User Created successfully'
                    })

                  }
                  
                  if(response.data.status === 'error')
                  {
                      swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Qandaydir Xatolik Boldi!',
                        footer: 'Xato: '+response.data.message
                      })
                  }

                })
                .catch(function(error){
                    console.log(error)
                })
            },

        },

        created() {
          this.loadUsers();
          //setInterval(()=>this.loadUsers(), 3000);
          
          
          Reload.$on('AfterCreate', () => {
            this.loadUsers();
          });
        }
    }
</script>
