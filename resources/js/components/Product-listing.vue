<template>
    <hr class="borderline">
    <div>
      <div class="searchDropdown">
        <p class="caption">---Name  ---</p>
        <input v-model="filter_name" type="text" class="form-control" placeholder="Default input">
      </div>
      <div class="searchDropdown">
        <p class="caption">---Category---</p>
        <select v-model="filter_category_id" class="form-select form-control">
          <option value="">---- doesn't matter ----</option>
          <option v-for="(item, index) in categories" :key="index" :value="item.id">{{ item.name }}</option>
        </select>
      </div>
      <div class="searchDropdown">
        <p class="caption">---Price (from)---</p>
        <input v-model="filter_price_gte" type="range" class="form-range" min="0" max="250" step="10">
        <p style="text-align: center;">{{ filter_price_gte }}</p>
      </div>
      <div class="searchDropdown">
        <p class="caption">---Price (to)---</p>
        <input  v-model="filter_price_lte" type="range" class="form-range" min="0" max="250" step="10">
        <p style="text-align: center;">{{ filter_price_lte }}</p>
      </div>
      <div class="searchNarrowDropdown">
        <p class="caption">---Weight---</p>
        <select v-model="filter_weight" class="form-select form-control">
          <option value="">- doesn't matter -</option>
          <option v-for="item in weights" :key="item" :value="item">{{ item }}</option>
        </select>
      </div>
      <div class="searchNarrowDropdown">
        <p class="caption">---Length--</p>
        <select v-model="filter_length" class="form-select form-control">
          <option value="">- doesn't matter -</option>
          <option v-for="item in lengths" :key="item" :value="item">{{ item }}</option>
        </select>
      </div>
      <div class="searchNarrowDropdown">
        <p class="caption">---Width---</p>
        <select v-model="filter_width" class="form-select form-control">
          <option value="">- doesn't matter -</option>
          <option v-for="item in widths" :key="item" :value="item">{{ item }}</option>
        </select>
      </div>
    </div>
    <hr class="borderline" style="clear:both">
    <ProductCard @categories="handleCategories" @weights="handleWeights" @lengths="handleLengths" @widths="handleWidths" :api_url="`api/v1/products?${filter_name ? `filter[name]=${filter_name}&` : ''}${filter_category_id ? `filter[category_id]=${filter_category_id}&` : ''}${filter_price_gte ? `filter[price-gte]=${filter_price_gte}&` : ''}${filter_price_lte ? `filter[price-lte]=${filter_price_lte}&` : ''}${filter_weight ? `filter[weight]=${filter_weight}&` : ''}${filter_length ? `filter[length]=${filter_length}&` : ''}${filter_width ? `filter[width]=${filter_width}&` : ''}`"/>
    <hr class="borderline" style="clear:both">
  </template>
   
  <script>
  import ProductCard from './ProductCard.vue'
  
  export default {
    components: {
      ProductCard
    },
    data() {
        return {
          api_url: "",
          filter_name: "",
          filter_category_id: "",
          filter_price_gte: "",
          filter_price_lte: "",
          filter_weight: "",
          filter_length: "",
          filter_width: "",
          categories: [],
          weights: [],
          lengths: [],
          widths: [],
      };
    },
    created() {
      const params = new URLSearchParams(this.$route.query);
      this.filter_category_id = params.get('filter[category_id]') || '';
      this.$router.replace({'query': null});
    },
     methods: {
      handleCategories(value) {
        this.categories = value;
      },
      handleWeights(value) {
        this.weights = value;
      },
      handleLengths(value) {
        this.lengths = value;
      },
      handleWidths(value) {
        this.widths = value;
      }
    }
  }
  </script>
  
  <style>
  .caption {
    margin: 0;
    margin-bottom: 10px;
    margin-left:20px;
  }

    .searchDropdown {
      width: 11rem;
      margin-left:10px;
      margin-bottom:16px;
      float:left;
    }

    .searchNarrowDropdown {
      width: 8.7rem;
      margin-left:10px;
      margin-bottom:16px;
      float:left;
    }
  </style>