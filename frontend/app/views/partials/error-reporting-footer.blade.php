<div class="error-reporting">
    <?php

    list($lastCommitOnInstall, $upstreamLatest, $lastCommitTimestamp, $upstreamTimestamp) = PaperworkHelpers::getHashes();
    ?>
    @if(empty($lastCommitOnInstall))
        <div class="alert alert-warning" role="alert">
            <p>[[Lang::get('messages.error_version_check')]]</p>
        </div>
    @elseif($lastCommitOnInstall === $upstreamLatest)
        <div class="alert alert-warning" role="alert">
            <p>[[Lang::get('messages.found_bug')]]</p>
        </div>
    @elseif(strtotime($lastCommitTimestamp) > strtotime($upstreamTimestamp))
        <div class="alert alert-warning" role="alert">
            <p>[[Lang::get('messages.found_bug_newer_commit_installed')]]
    @else
        <div class="alert alert-danger" role="alert">
            <p>[[Lang::get('messages.new_version_available')]]
        </div>
    @endif
</div>
