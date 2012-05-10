<?php


class rtValidatedFile extends sfValidatedFile {
  /**
   * Generates a random filename for the current file.
   *
   * @return string A random name to represent the current file
   */
  public function generateFilename()
  {
    return sha1($this->getOriginalName().rand(11111, 99999)).$this->getOriginalExtension();
  }
}