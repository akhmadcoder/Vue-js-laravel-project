<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Klentlar Ro'yhati</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-block btn-primary" @click="newModal">Yangi Klent Qo'shish
                  <i class="fas fa-user-plus fa-faw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nomi</th>
                      <th>Tel</th>
                      <th>Adres</th>
                      <th>Qo'shimcha Ma'lumotlar</th>
                      <th>Turi</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="client in clients" :key="client.id">
                      <td>{{client.id}}</td>
                      <td>{{client.name}}</td>
                      <td>{{client.phone}}</td>
                      <td>{{client.address}}</td>
                      <td>{{client.description}}</td>
                      <td>{{client.categories.name}}</td>
                      <td>
                          <a href="#" @click="editModal(client)">
                            <i class="fa fa-edit"></i>
                          </a>
                           | 
                          <a href="#" @click="deleteClient(client.id)">
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
<div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-if="!editmode" class="modal-title" id="exampleModalLabel">Yangi Klent Qo'shish</h5>
        <h5 v-if="editmode" class="modal-title" id="exampleModalLabel">Klent Ma'lumotlarini O'zgartirish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateClient() : createClient()">
      <div class="modal-body">
        <div class="form-group">
          <input v-model="form.name" type="text" name="name" 
            placeholder="Nomi"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
          <input v-model="form.phone" type="text" name="phone" 
            placeholder="Telefon Raqami"
            class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
          <has-error :form="form" field="phone"></has-error>
        </div>

        <div class="form-group">
          <input v-model="form.address" type="text" name="address" 
            placeholder="Adresi"
            class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
          <has-error :form="form" field="address"></has-error>
        </div>
        
        <div class="form-group">
          <input v-model="form.description" type="text" name="description" 
            placeholder="Qo'shimcha Ma'lumotlar"
            class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
          <has-error :form="form" field="description"></has-error>
        </div>

        <div v-if="!editmode" class="form-group">
          <select v-model="form.client_category_id" name="client_category_id" id="client_category_id" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('client_category_id') }">
            <option value="">Klent Turi</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>

          </select>

          <has-error :form="form" field="client_category_id"></has-error>
        </div>
        
        <div v-if="editmode" class="form-group">
          <select v-model="form.client_category_id" name="client_category_id" id="client_category_id" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('client_category_id') }">
            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
          </select>

          <has-error :form="form" field="client_category_id"></has-error>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button v-if="!editmode" type="submit" class="btn btn-primary">Qo'shish</button>
        <button v-if="editmode" type="submit" class="btn btn-primary">O'zgartirish</button>
      </div>
      </form>
    </div>
  </div>
</div>

    </div>
</template>

<script>
    export default {

        data(){
            return{
                editmode: false,
                categories: {},
                clients: {},
                form: new Form({
                    id: '',
                    name: '',
                    phone: '',
                    address: '',
                    description: '',
                    client_category_id: '',
                })
            }

        }, 

        methods:{

            deleteClient(id){

                swal.fire({
                    title: 'Ochirmoqchimisiz?',
                    text: "Ochirilgan narsa qayta tiklanmaydi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xa, ochir!'
                  }).then((result) => {

                    if(result.value){

                      // send request to the server
                      this.form.delete('api/clients/'+id)
                      .then(function(response){

                        if(response.data.status === 'success')
                        {
                          Reload.$emit('ReloadContent')
                          swal.fire(
                            'Deleted!',
                            'Klent muvaffaqiyatli ochirildi.',
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

            editModal(client){
                this.editmode = true
                $('#addEditModal').modal('show')
                this.form.fill(client)
            },

            loadClients(){
                axios.get('api/clients').then(({ data }) => (
                    this.clients = data.clients,
                    this.categories = data.categories
                ));
            },

            updateClient(){
                this.form.put('api/clients/'+this.form.id)
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent');
                      swal.fire(
                        'Updated!',
                        'Klent muvaffaqiyatli ozgartirildi.',
                        'success'
                      )
                    }
                })
                .catch(()=>{

                    // if failed
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                    })
                })

            },

            createClient(){
                this.form.post('api/clients')
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent')
                      swal.fire(
                        'Created!',
                        'Yangi Klent qoshildi.',
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
                })

            },

            newModal(){
                
                this.editmode = false
                $('#addEditModal').modal('show')
                this.form.reset()
            },

        },

        mounted() {
            this.loadClients()

            Reload.$on('ReloadContent', () => {
                this.loadClients();
            });
        }
    }
</script>
