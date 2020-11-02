<answer :answer=" {{ $answer }}" inline-template>
  <div class="media post">
    <vote :model="{{ $answer }}" name="answer"></vote>
    <div class="media-body">
      <form v-if="editing" @submit.prevent="update">
        <div class="form-group">
          <textarea rows="10" class="form-control" v-model="body" required></textarea>
        </div><!-- form-group -->
        <button class="btn btn-outline-primary btn-sm" type="submit" :disabled="isInvalid">Update</button>
        <button class="btn btn-outline-secondary btn-sm" type="button" @click.prevent="cancel">Cancel</button>
      </form>
      <div v-else>
        <div v-html="bodyHtml"></div>
        <div class="row">
          <div class="col-4">
            <div class="ml-auto">
              @can('update', $answer)
                <a @click.prevent="edit" class="btn btn-outline-info btn-sm">Edit</a>
              @endcan
              @can('delete', $answer)
                <button class="btn btn-outline-danger btn-sm" @click="destroy">Delete</button>
              @endcan
            </div><!-- ml-auto -->
          </div><!-- col-4 -->
          <div class="col-4"></div><!-- col-4 -->
          <div class="col-4">
            <user-info :model="{{ $answer }}" label="Answered"></user-info>
          </div><!-- col-4 -->
        </div>
      </div>
    </div><!-- media-body -->
  </div><!-- media -->
</answer>