<template>
  <div class="container  my-5">
    <div class="col-md-8 offset-md-4">
      <div class="row">
        <div class="col-md-4 mb-3">
          <button class="btn btn-success" @click="create()">Create</button>
        </div>
        <form class="col-md-8" @submit.prevent="view">
          <div class="input-group mb-3">
            <input type="text" class="form-control rounded-0" placeholder="Search Products" v-model="searchData">
            <button class="input-group-text rounded-0" type="submit">Search</button>
          </div>

        </form>
      </div>
    </div>
    <div class="row">
      <!-- Create And Edit Form -->
      <div class="col-md-4">
        <div class="card">
          <h4 class="card-header">
            {{ isEditMode ? 'Edit Product':'Create Product' }}
          </h4>
          <div class="card-body">
            <form @submit.prevent="isEditMode ? update() : store()">
              <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control rounded-0" name="name" v-model="product.name"
                :class="{ 'is-invalid': product.errors.has('name') }">
                <has-error :form="product" field="name"></has-error>

              </div>
              <div class="mb-3">
                <label>Price</label>
                <input type="number" class="form-control rounded-0" name="price" v-model="product.price"
                :class="{ 'is-invalid': product.errors.has('price') }">
                <has-error :form="product" field="price"></has-error>
              </div>
              <button class="btn btn-success" type="submit">
                {{ isEditMode ? 'Update' : 'Save' }}
              </button>
            </form>
          </div>
        </div>
      </div>
      <!-- Show All Data -->
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th colspan="2" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products.data">
                <th scope="row">{{ product.id }}</th>
                <td>{{ product.name }}</td>
                <td>{{ product.price }}$</td>
                <td class="text-center">
                  <button class="btn btn-info" @click="edit(product)">Edit</button>
                </td>
                <td class="text-center">
                  <button class="btn btn-danger" @click="destroy(product.id)">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <pagination :data="products" @pagination-change-page="view"></pagination>
  </div>
</template>

<script type="text/javascript" charset="utf-8">

  export default {
    name: 'ProductComponent',
    data() {
      return {
        products: {},
        product: new Form({
          id: '',
          name: '',
          price: ''
        }),
        isEditMode: false,
        searchData: ''
      }
    },
    methods: {
      view(page = 1) {
        // Start Progress Bar
        this.$Progress.start();
        /* Get All Data */
        axios.get('/api/products?page='+page+'&search='+this.searchData)
        .then(response=> {
          this.products = response.data;
          this.$Progress.stop();
        })
        .catch(errors=> {
          this.$Progress.fail()
        })
      },
      create() {
        this.isEditMode = false;
        this.product.reset();
      },
      store() {
        this.product.post('/api/products')
        .then(response=> {
          // Call All Data
          this.view();
          this.product = {
            name: '',
            price: ''
          };
          console.log(response.data)
        })
      },
      edit(product) {
        this.isEditMode = true;
        this.product.fill(product);
        this.product.clear();
      },
      update() {
        this.product.put(`/api/products/${this.product.id}`)
        .then(response=> {
          this.view();
          console.log(response.data)
        })
      },
      destroy(id) {

        Swal.fire({
          title: 'Are you sure?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // Delete Data When Confirm is true
            axios.delete(`/api/products/${id}`)
            .then(response=> {
              this.view();
            });
            Swal.fire(
              'Deleted!',
              'success'
            )
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })
            Toast.fire({
              icon: 'success',
              title: 'Deleted successfully'
            })
          }
        })
      },
    },
    created() {
      this.view();
    }
  }
  </script>