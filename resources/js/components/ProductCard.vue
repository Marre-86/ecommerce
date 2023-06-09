<template>
  <div v-if="products.length > 0" v-for="product in products" :key="product.id"  class="card mb-3" style="width: 18rem; float:left; margin-left:10px">
    <h3 class="card-header ellipsis">{{ product.name }}</h3>
    <div class="card-body">
      <h6 class="card-subtitle text-muted" style="width: 10rem; float:left">{{ product.category_name }}</h6>
      <button type="button" class="btn btn-info disabled" style="background-color:#007bff;float:right">{{ product.price }} $</button>
    </div>
    <div class="button-container">

      <div v-if="product.image">
        <a :href="'storage/images/' + product.image" target="_blank">
          <img :src="'storage/images/' + product.image" :alt="product.image" class="img"/>
        </a>
      </div>
      <div v-else>
        <img :src="'storage/images/noimage.png'" alt="No image available" class="img"/>
      </div>

      <form action="/cart" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" :value=product.id name="id">
        <input type="hidden" :value=product.name name="name">
        <input type="hidden" :value=product.price name="price">
        <input type="hidden" value="1" name="quantity">
        <button class="btn btn-dark">Add To Cart</button>
      </form> 
    </div>
    <div class="card-body">
      <p class="card-text ellipsis" style="height: 4.3rem;">{{ product.description }}</p>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Weight: {{ product.weight }}</li>
      <li class="list-group-item">Length: {{ product.length }}</li>
      <li class="list-group-item">Width: {{ product.width }}</li>
    </ul>
  </div>
  <div v-else class="card border-primary mb-3" style="max-width: 20rem; text-align: center; margin:auto">
      <div class="card-body">
        <h4 class="card-title">No results</h4>
        <p class="card-text">Try to change your conditions</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {

  props: [
    'api_url'
  ],
  data() {
    return {
      allProducts: [],
      products: [],
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
  },
  computed: {
    categories() {
      const categories = [];
      for (const product of this.allProducts) {
        let current = {}
        current['id'] = product.category_id
        current['name'] = product.category_name
        const hasValue = categories.some(item => item.id === product.category_id)
        if (!hasValue) {
          categories.push(current)
        }        
      }
      return categories;
    },
    weights() {
      const weights = [];
      for (const product of this.allProducts) {
        if (!weights.includes(product.weight) && product.weight !== null) {
          weights.push(product.weight)
        }
      }
      return weights.sort();
    },
    lengths() {
      const lengths = [];
      for (const product of this.allProducts) {
        if (!lengths.includes(product.length) && product.length !== null) {
          lengths.push(product.length)
        }
      }
      return lengths.sort();
    },
    widths() {
      const widths = [];
      for (const product of this.allProducts) {
        if (!widths.includes(product.width) && product.width !== null) {
          widths.push(product.width)
        }
      }
      return widths.sort();
    },
  },
  created() {
    axios.get('api/v1/products')
        .then(res => {
          this.allProducts = res.data.data
          this.$emit('categories', this.categories)
          this.$emit('weights', this.weights)
          this.$emit('lengths', this.lengths)
          this.$emit('widths', this.widths)
        })
        .catch(error => {
          console.log(error)
          // Manage errors if found any
        })
  },
  watch: {
    api_url: {
      handler(){
        axios.get(this.api_url)
        .then(res => {
          this.products = res.data.data
        })
        .catch(error => {
          console.log(error)
          // Manage errors if found any
        })
      },
      immediate: true
    }
  }
};
</script>

<style>
.ellipsis {
  height: 7rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.button-container{
display:inline-block;
position:relative;
}

.button-container button{
position: absolute;
bottom:0.5rem;
right:0.5rem;
}
</style>