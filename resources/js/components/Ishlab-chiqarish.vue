<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Ishlab Chiqarish</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-block btn-primary" @click="newModal">Maxsulot Qo'shish
                  <i class="fas fa-plus-square fa-faw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Maxsulot</th>
                      <th>Soni</th>
                      <th>Sanasi</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="product in products" :key="product.id">
                      <td>{{product.id}}</td>
                      <td>{{product.product.name}}</td>
                      <td>{{product.quantity}}</td>
                      <td>{{product.date | myDate}}</td>
                      <td>
                          <a href="#" @click="editModal(product)">
                            <i class="fa fa-edit"></i>
                          </a>
                           | 
                          <a href="#" @click="deleteProduct(product.id)">
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
        <h5 v-if="!editmode" class="modal-title" id="exampleModalLabel">Maxsulot Qo'shish</h5>
        <h5 v-if="editmode" class="modal-title" id="exampleModalLabel">Maxsulotni O'zgartirish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateProduct() : createProduct()">
      <div class="modal-body">
        <div class="form-group">
          <select v-model="form.product_id" name="product_id" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('product_id') }">
            <option value="">Maxsulot turi</option>
            <option v-for="productName in productNames" :key="productName.id" :value="productName.id">{{productName.name}}</option>
          </select>
          <has-error :form="form" field="product_id"></has-error>
        </div>

        <div class="form-group">
          <input v-model="form.quantity" type="number" name="quantity" 
            placeholder="Maxsulot Soni"
            class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
          <has-error :form="form" field="quantity"></has-error>
        </div>

        <div v-if="!editmode" class="form-group">
          <input v-model="form.date" type="date" name="date" 
            placeholder="Sana"
            class="form-control" :class="{ 'is-invalid': form.errors.has('date') }">
          <has-error :form="form" field="date"></has-error>
        </div>

        <div v-if="editmode" class="form-group">
          <input v-model="form.date" type="text" name="date" 
            placeholder="Sana"
            class="form-control" :class="{ 'is-invalid': form.errors.has('date') }">
          <has-error :form="form" field="date"></has-error>
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
                counter: 1,
                editmode: false,
                products: {},
                productNames: {},
                form: new Form({
                    id: '',
                    quantity: '',
                    date: '',
                    product_id: '',
                })

            }

        },
        methods:{
            deleteProduct(id){
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
                      this.form.delete('api/productions/'+id)
                      .then(function(response){

                        if(response.data.status === 'success')
                        {
                          Reload.$emit('ReloadContent')
                          swal.fire(
                            'Deleted!',
                            'Maxsulot muvaffaqiyatli ochirildi.',
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

            editModal(product){
                this.editmode = true
                $('#addEditModal').modal('show')
                this.form.fill(product)
            },
            
            updateProduct(){
                this.form.put('api/productions/'+this.form.id)
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent');
                      swal.fire(
                        'Updated!',
                        'Maxsulot muvaffaqiyatli ozgartirildi.',
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

            createProduct(){
                this.form.post('api/productions')
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent')
                      swal.fire(
                        'Created!',
                        'Yangi Maxsulot qoshildi.',
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

            loadProducts(){
                axios.get('api/productions')
                    .then(({ data }) => (
                        this.products = data.products,
                        this.productNames = data.productNames
                    ))
                    .catch(()=>{

                        // if failed
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Qandaydir Xatolik Boldi!',
                        })
                    });
            },

            newModal(){
                this.editmode = false
                $('#addEditModal').modal('show')
                this.form.reset()
            },

        },
        mounted() {
            this.loadProducts()

            Reload.$on('ReloadContent', () => {
                this.loadProducts();
            });
        }
    }
</script>
