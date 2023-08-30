
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="modalDeleteLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content notification-modal">
      <div class="modal-body">
          <div class="modal-delete-noti">
            <div class="notification-modal-icon">
               <img src="{{asset('assets/images/trash-bin.gif')}}" alt="trash-bin.gif">
            </div>
            <div class="notification-modal-content">
                <h5>   {{translate(Arr::get(config('language'),'are_you_sure','are_you_sure'))}}</h5>
                <p class="warning-message"></p>
            </div>
          </div>

        <div class="#modalDelete modal-footer">
          <button type="button"
              class="i-btn btn--lg bg-soft-warning"
              data-bs-dismiss="modal">
              {{translate("No")}}
          </button>
          <a href="javascript:void(0)" class="i-btn btn--lg delete-btn btn-delete"
             id="delete-href">
            {{translate('Yes')}}
         </a>
        </div>
      </div>
    </div>
  </div>
</div>
