<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Harajat Turlari</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-block btn-primary" @click="newModal">Harajat Turi Qo'shish
                  <i class="fas fa-plus-square fa-faw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nomi</th>
                      <th>Qo'shimcha Ma'lumotlar</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="expense in expenses" :key="expense.id">
                      <td>{{expense.id}}</td>
                      <td>{{expense.name}}</td>
                      <td>{{expense.description}}</td>
                      <td>
                          <a href="#" @click="editModal(expense)">
                            <i class="fa fa-edit"></i>
                          </a>
                           | 
                          <a href="#" @click="deleteExpense(expense.id)">
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
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-if="!editmode" class="modal-title" id="exampleModalLabel">Harajat Turi Qo'shish</h5>
        <h5 v-if="editmode" class="modal-title" id="exampleModalLabel">Harajat Turini O'zgartirish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateExpense() : createExpense()">
      <div class="modal-body">
        <div class="form-group">
          <input v-model="form.name" type="text" name="name" 
            placeholder="Harajat Turi Nomi"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
          <input v-model="form.description" type="text" name="description" 
            placeholder="Qo'shimcha Ma'lumotlar"
            class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
          <has-error :form="form" field="description"></has-error>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button v-if="!editmode" type="submit" class="btn btn-primary">Saqlash</button>
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
                expenses: {},
                form: new Form({
                    id: '',
                    name: '',
                    description: '',
                })
            }
        },

        methods:{
            deleteExpense(id){
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
                      this.form.delete('api/expenses/'+id)
                      .then(function(response){

                        if(response.data.status === 'success')
                        {
                          Reload.$emit('ReloadContent')
                          swal.fire(
                            'Deleted!',
                            'Harajat Turi muvaffaqiyatli ochirildi.',
                            'success'
                          )

                        }

                      })
                      .catch(()=>{

                          swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Qandaydir Xatolik Boldi!',
                          })

                      });

                    }
                  })

            },

            editModal(expense){
                this.editmode = true
                $('#addEditModal').modal('show')
                this.form.fill(expense)
            },

            loadExpenses(){
                axios.get('api/expenses').then(({ data }) => (
                    this.expenses = data.expenses
                ));
            },

            updateExpense(){
                this.form.put('api/expenses/'+this.form.id)
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent');
                      swal.fire(
                        'Updated!',
                        'Harajat Haqida Malumotlar muvaffaqiyatli ozgartirildi.',
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

            createExpense(){
                this.form.post('api/expenses')
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent')
                      swal.fire(
                        'Created!',
                        'Yangi Harajat Turi qoshildi.',
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

            newModal(){
                this.editmode = false
                $('#addEditModal').modal('show')
                this.form.reset()
            },

        },

        mounted() {
            this.loadExpenses()

            Reload.$on('ReloadContent', () => {
                this.loadExpenses();
            });
        }
    }
</script>
