<div class="table-responsive">
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
         <tr>
            <th><i class="fas fa-user-circle"></i>&nbsp;Window</th>
            <th><i class="fas fa-id-card-alt"></i>&nbsp;Queue Number</th>
            <th><i class="fas fa-id-card-alt"></i>&nbsp;Priority</th>
         </tr>
      </thead>
        @foreach($windows as $window)
        <tr>
            <td>{{ $window->queue_window_number }}</td>
            <td>{{ $window->queue_number }}</td>
            <td>
                   @if($window->queue_priority == 1)
                   <span class="badge badge-dot">
                       <i class="bg-success"></i>
                    </span>
                       <i class="fas fa-check-circle"></i>
                   @endif
                    @if($window->queue_priority == 0)
                    <span class="badge badge-dot">
                        <i class="bg-danger"></i>
                    </span>
                        <i class="fas fa-times-circle"></i>
                   @endif
                 </span>
             </td>
        </tr>
        @endforeach
   </table>
  </div>
