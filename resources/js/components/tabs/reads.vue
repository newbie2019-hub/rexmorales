<template>
  <div>
    <div class="table-responsive mt-2">
      <table class="table table-hover" id="readingsTable">
        <thead>
          <tr>
            <th scope="col">Book Title</th>
            <th scope="col">Author</th>
            <th scope="col">Genre</th>
            <th scope="col">Synopsis</th>
            <th scope="col">Rating</th>
            <th scope="col">Review</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(book, i) in reading.data" :key="i">
            <td>{{ book.booktitle }}</td>
            <td>{{ book.genre }}</td>
            <td>{{ book.author }}</td>
            <td>
              <a href="" @click.prevent="viewSynopsis(book)">View</a>
            </td>
            <td>
              <star-rating
                v-bind:max-rating="5"
                v-bind:star-size="15"
                v-bind:rounded-corners="true"
                v-bind:padding="10"
                active-color="rgba(241, 112, 6, 0.966)"
                v-bind:animate="true"
                v-bind:rating="parseInt(book.rating)"
                v-bind:read-only="true"
                v-bind:show-rating="false"
              />
            </td>
            <td>
              <a href="" @click.prevent="viewReview(book)">View</a>
            </td>
            <td>
              <button
                class="btn btn-primary btn-sm"
                @click.prevent="editBook(book)"
              >
                Edit
              </button>
              <button
                class="btn btn-danger btn-sm"
                @click.prevent="setDelete(book)"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="" v-if="reading.data.length == 0" style="overflow: hidden">
        <h5 class="text-center mt-5 mb-5">
          You currently have no books here, Wanna add something?
        </h5>
      </div>
    </div>
    <div class="row justify-content-end mr-1">
      <div class="form-group mr-2">
        <select
          id="customSelect"
          @change="ChangeTotal($event)"
          class="custom-select"
        >
          <option selected value="4">4</option>
          <option value="6">6</option>
          <option value="8">8</option>
          <option value="10">10</option>
        </select>
      </div>
      <pagination
        :data="reading"
        @pagination-change-page="getReads"
      ></pagination>
    </div>
  </div>
</template>
<script>
export default {};
</script>