      <form id="serializerForm" method="post">
          <div class="row-fluid">
              <label class="span2">From format</label>

              <select class="span2" name="data[from]">
                  <?php foreach ($inFormats as $format) : ?>
                      <option <?= (!empty($data['from']) && $data['from'] === $format) ? 'selected="selected"' : ''; ?>><?= $format ?></option>
                  <?php endforeach; ?>
              </select>
          </div>
          <div class="row-fluid">
              <label class="span2">To format</label>
              <select class="span2 lfloat" name="data[to]">
                  <?php foreach ($outFormats as $format) : ?>
                      <option <?= (!empty($data['to']) && $data['to'] === $format) ? 'selected="selected"' : ''; ?>><?= $format ?></option>
                  <?php endforeach; ?>
              </select>
              <div class="span1">
                  <input type="submit" class="btn" value="Go"/>
              </div>
          </div>
          <div class="row-fluid">
              <div class="span6">
                  <label>Data source</label>
                  <textarea class="data-source" name="data[source]"><?php echo (!empty($data['source'])) ? htmlspecialchars($data['source']) : ''; ?></textarea>
              </div>
              <div class="span6<?= !empty($error) ? ' error' : ''; ?>" >
                  <label>Data result</label>
                  <textarea class="data-result" ><?php echo!empty($result) ? $result : ''; ?></textarea>
              </div>
          </div>
      </form>