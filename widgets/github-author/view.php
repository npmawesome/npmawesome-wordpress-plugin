<div class="github-author">
  <div class="user">
    <dl class="user-data">
      <dt>Avatar:</dt>
      <dd class="user-avatar">
        <img src="<?php echo $profile['avatar_url']; ?>"/>
      </dd>

      <dt>Fullname:</dt>
      <dd class="user-name"><?php echo $profile['name']; ?></dd>

      <dt>Account:</dt>
      <a class="user-github-url" href="<?php echo $profile['name']; ?>"><dd class="user-account"><?php echo $profile['name']; ?></dd></a>
    </dl>
    <dl class="user-stats">
      <dt>Repos</dt>
      <a class="user-repos-url" href="<?php echo $profile['html_url'].'?tab=repositories'; ?>"><dd class="user-repos" data-stats="repos"><?php echo $profile['public_repos']; ?></dd></a>

      <dt>Followers</dt>
      <a class="user-followers-url" href="<?php echo $profile['html_url'].'/followers'; ?>"><dd class="user-followers" data-stats="followers"><?php echo $profile['followers']; ?></dd></a>
    </dl>
  </div>
</div>
