<div class="error-reporting">
    <?php

    list($lastCommitOnInstall, $upstreamLatest, $lastCommitTimestamp, $upstreamTimestamp) = PaperworkHelpers::getHashes();
    ?>
        <div class="alert alert-warning" role="alert">
    @if(empty($lastCommitOnInstall))
            <p>[[Lang::get('messages.error_version_check')]]</p>
    @elseif($lastCommitOnInstall === $upstreamLatest)
            <p>[[Lang::get('messages.found_bug')]]</p>
    @elseif(strtotime($lastCommitTimestamp) > strtotime($upstreamTimestamp))
            <p>[[Lang::get('messages.found_bug_newer_commit_installed')]]
    @else
            <p>[[Lang::get('messages.new_version_available')]]
    @endif
            <p>[[Lang::get('messages.dblclick_dismiss')]]
        </div>
</div>
