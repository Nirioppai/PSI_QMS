<div class="table-responsive">
  <table class="table align-items-center table-flush white-container">
    <thead class="thead-light ">
      <tr>
        <th class="text-left text-dark">Number</th>
        <th class="text-left text-dark">Name</th>
        <th class="text-left text-dark" data-toggle="tooltip" data-placement="right" title="'<b class= text-danger> Waiting </b>' indicates that a number has been <b>skipped</b>." data-html="true"><i class="fas fa-info-circle"></i> Status</th>
        <th class="text-left text-dark" data-toggle="tooltip" data-placement="left" title="' <span class='badge badge-dot'>
          <i class='bg-waiting'></i>
        </span>
        <i class='fas fa-check-circle'></i> ' indicates that a number is <b>prioritized</b>." data-html="true"><i class="fas fa-info-circle"></i> Priority</th>
        <th class="text-left text-dark" data-toggle="tooltip" data-placement="left" title="' <span class='badge badge-dot'>
          <i class='bg-waiting'></i>
        </span>
        <i class='fas fa-check-circle'></i> ' indicates that a number <b>has a note</b>." data-html="true"><i class="fas fa-info-circle"></i> Note</th>
      </tr>
    </thead>
    <tbody>
      @foreach($onPool as $pool)
      <tr>
      <td class="text-left">{{ $pool->queue_number }}</td>
      <td class="text-left">{{ $pool->client_name }}</td>
      @if($pool->queue_action == 0)
            <td class="text-left text-waiting"><b>Waiting</b></td>
        @else
            <td class="text-left text-danger"><b>Waiting</b></td>
        @endif
          @if($pool->queue_priority == 1)
                <td class="text-left">
            <span class="badge badge-dot">
              <i class="bg-success"></i>
            </span>
                    <i class="fas fa-check-circle"></i>
                </td>
            @else
                <td class="text-left">
            <span class="badge badge-dot">
              <i class="bg-danger"></i>
            </span>
                    <i class="fas fa-times-circle"></i>
                </td>
            @endif
        @if($pool->queue_note)
            <td class="text-left">
                <span class="badge badge-dot">
                  <i class="bg-success"></i>
                </span>
                <i class="fas fa-check-circle"></i>
            </td>
        @else
            <td class="text-left">
                <span class="badge badge-dot">
                  <i class="bg-danger"></i>
                </span>
                <i class="fas fa-times-circle"></i>
            </td>
        @endif

      </tr>
      @endforeach
    </tbody>
  </table>
</div>
