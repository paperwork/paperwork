<div class="error-reporting">
    <?php

    list($lastCommitOnInstall, $upstreamLatest) = PaperworkHelpers::getHashes();
    ?>
    @if(empty($lastCommitOnInstall))
        <div class="alert alert-warning" role="alert">
            <p>[[Lang::get('messages.error_version_check')]]</p>
        </div>
    @elseif($lastCommitOnInstall === $upstreamLatest)
        <div class="alert alert-warning" role="alert">
            <p>[[Lang::get('messages.found_bug')]]</p>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            <p>[[Lang::get('messages.new_version_available')]]
        </div>
    @endif
</div>
